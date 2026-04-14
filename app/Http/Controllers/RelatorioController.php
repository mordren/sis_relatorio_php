<?php

namespace App\Http\Controllers;

use App\Enums\FinalidadeRelatorio;
use App\Enums\ProcessoRelatorio;
use App\Http\Requests\StoreRelatorioRequest;
use App\Http\Requests\UpdateRelatorioRequest;
use App\Models\Cliente;
use App\Models\ProdutoTransportado;
use App\Models\RelatorioCompartimento;
use App\Models\RelatorioDescontaminacao;
use App\Models\User;
use App\Models\Veiculo;
use App\Services\SnapshotService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RelatorioController extends Controller
{
    public function __construct(
        private readonly SnapshotService $snapshotService
    ) {}

    // -----------------------------------------------------------------------
    // Report CRUD
    // -----------------------------------------------------------------------

    public function create(): View
    {
        $clientes     = Cliente::where('ativo', true)->orderBy('nome_razao_social')->get();
        $responsaveis = User::orderBy('name')->get();

        return view('relatorios.create', compact('clientes', 'responsaveis'));
    }

    public function store(StoreRelatorioRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $cliente   = Cliente::findOrFail($validated['cliente_id']);
        $veiculo   = Veiculo::findOrFail($validated['veiculo_id']);

        $reportData = [
            'status'                 => 'RASCUNHO',
            'data_servico'           => $validated['data_servico'],
            'responsavel_tecnico_id' => $validated['responsavel_tecnico_id'],
            'processo'               => ProcessoRelatorio::VAPOR->value,
            'observacoes'            => $validated['observacoes'] ?? null,
            'lacre_entrada'          => null,
            'lacre_saida'            => null,
            'criado_por_id'          => $request->user()->id,
        ];

        // Finalidade is always VERIFICACAO_METROLOGICA in this workflow
        $finalidadesData = [
            ['finalidade' => FinalidadeRelatorio::VERIFICACAO_METROLOGICA->value, 'descricao_outros' => null],
        ];

        $relatorio = $this->snapshotService->createFullReport(
            $reportData,
            $finalidadesData,
            $cliente,
            $veiculo,
        );

        // Redirect to edit so the user can fill compartment details immediately
        return redirect()
            ->route('relatorios.edit', $relatorio)
            ->with('success', 'Relatório criado! Preencha os compartimentos abaixo.');
    }

    public function show(RelatorioDescontaminacao $relatorio): View
    {
        $relatorio->load([
            'clienteSnapshot',
            'veiculoSnapshot',
            'finalidades',
            'compartimentos',
            'equipamentosUtilizados',
            'responsavelTecnico',
        ]);

        return view('relatorios.show', compact('relatorio'));
    }

    public function edit(RelatorioDescontaminacao $relatorio): View
    {
        $relatorio->load([
            'clienteSnapshot',
            'veiculoSnapshot',
            'finalidades',
            'compartimentos',
            'responsavelTecnico',
        ]);

        $responsaveis = User::orderBy('name')->get();
        $produtos     = ProdutoTransportado::where('ativo', true)->orderBy('nome')->get();

        return view('relatorios.edit', compact('relatorio', 'responsaveis', 'produtos'));
    }

    public function update(UpdateRelatorioRequest $request, RelatorioDescontaminacao $relatorio): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($relatorio, $validated) {
            $relatorio->update([
                'data_servico'           => $validated['data_servico'],
                'responsavel_tecnico_id' => $validated['responsavel_tecnico_id'],
                'observacoes'            => $validated['observacoes'] ?? null,
            ]);

            $compartimentosInput = collect($validated['compartimentos'])->keyBy('id');

            // Phase 1: set temporary numbers to avoid unique(relatorio_id, numero) conflicts.
            foreach ($compartimentosInput as $id => $data) {
                RelatorioCompartimento::where('id', $id)
                    ->where('relatorio_id', $relatorio->id)
                    ->update(['numero' => 1_000_000 + (int) $id]);
            }

            // Phase 2: write final values with server-computed SRD fields.
            foreach ($compartimentosInput as $id => $data) {
                $capacidade  = isset($data['capacidade_litros']) && $data['capacidade_litros'] !== ''
                    ? (float) $data['capacidade_litros']
                    : null;
                $nomeProduto = $data['produto_anterior_nome'] ?? null;

                RelatorioCompartimento::where('id', $id)
                    ->where('relatorio_id', $relatorio->id)
                    ->update([
                        'numero'                => (int) $data['numero'],
                        'capacidade_litros'     => $capacidade,
                        'produto_anterior_nome' => $nomeProduto,

                        // SRD computed fields — always derived server-side
                        'numero_onu'    => $this->resolveNumeroOnu($nomeProduto),
                        'classe_risco'  => '3',
                        'pressao_vapor' => null,   // displayed as NA in UI
                        'tempo_minutos' => $capacidade !== null
                            ? (int) round($capacidade * 12) : null,
                        'massa_vapor'   => null,   // displayed as NA in UI
                        'volume_ar'     => $capacidade !== null
                            ? round($capacidade * 168, 4) : null,
                        'neutralizante' => 'NA',

                        // Lacre fields are not used in this workflow
                        'lacre_entrada_numero' => null,
                        'lacre_saida_numero'   => null,

                        'observacao' => $data['observacao'] ?? null,
                    ]);
            }
        });

        return redirect()
            ->route('relatorios.show', $relatorio)
            ->with('success', 'Relatório atualizado com sucesso!');
    }

    // -----------------------------------------------------------------------
    // AJAX
    // -----------------------------------------------------------------------

    /**
     * Return vehicles belonging to the given client (for the dependent dropdown).
     * Only active vehicles with this client as proprietário are returned.
     */
    public function veiculosParaCliente(Cliente $cliente): JsonResponse
    {
        $veiculos = Veiculo::where('proprietario_id', $cliente->id)
            ->where('ativo', true)
            ->orderBy('placa')
            ->get(['id', 'placa', 'marca', 'modelo', 'numero_compartimentos']);

        return response()->json(
            $veiculos->map(fn ($v) => [
                'id'                    => $v->id,
                'text'                  => $v->placa . ' — ' . $v->marca . ' ' . $v->modelo,
                'numero_compartimentos' => $v->numero_compartimentos,
            ])
        );
    }

    // -----------------------------------------------------------------------
    // Private helpers
    // -----------------------------------------------------------------------

    /**
     * Look up the UN number for a product from the canonical catalog.
     * Returns null if the product is not found.
     */
    private function resolveNumeroOnu(?string $nomeProduto): ?string
    {
        if (! $nomeProduto) {
            return null;
        }

        return ProdutoTransportado::where('nome', $nomeProduto)
            ->where('ativo', true)
            ->value('numero_onu');
    }
}

