<?php

namespace App\Http\Controllers;

use App\Enums\FinalidadeRelatorio;
use App\Enums\ProcessoRelatorio;
use App\Enums\StatusRelatorio;
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
use Illuminate\Http\Request;
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
        $responsaveis       = User::orderBy('name')->get();
        $currentUserId      = auth()->id();
        $oldCliente         = null;
        if (old('cliente_id')) {
            $oldCliente = Cliente::find(old('cliente_id'), ['id', 'nome_razao_social', 'cpf_cnpj']);
        }

        return view('relatorios.create', compact('responsaveis', 'currentUserId', 'oldCliente'));
    }

    /**
     * Live search for clients (autocomplete).
     * Accepts ?q= for name search, or ?id= to fetch a single client by PK.
     */
    public function searchClientes(Request $request): JsonResponse
    {
        $q  = trim((string) $request->query('q', ''));
        $id = (int) $request->query('id', 0);

        if ($id > 0) {
            $c = Cliente::find($id, ['id', 'nome_razao_social', 'cpf_cnpj']);
            if (! $c) {
                return response()->json([]);
            }
            return response()->json([[
                'id'   => $c->id,
                'text' => $c->nome_razao_social . ($c->cpf_cnpj ? ' — ' . $c->cpf_cnpj : ''),
                'nome' => $c->nome_razao_social,
            ]]);
        }

        if ($q === '') {
            return response()->json([]);
        }

        $clientes = Cliente::where('ativo', true)
            ->where('nome_razao_social', 'like', '%' . $q . '%')
            ->orderBy('nome_razao_social')
            ->limit(15)
            ->get(['id', 'nome_razao_social', 'cpf_cnpj']);

        return response()->json($clientes->map(fn ($c) => [
            'id'   => $c->id,
            'text' => $c->nome_razao_social . ($c->cpf_cnpj ? ' — ' . $c->cpf_cnpj : ''),
            'nome' => $c->nome_razao_social,
        ]));
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

    /**
     * Print-friendly certificate view. Only available for EMITIDO reports.
     */
    public function print(RelatorioDescontaminacao $relatorio): View|RedirectResponse
    {
        if ($relatorio->status !== StatusRelatorio::EMITIDO) {
            return redirect()
                ->route('relatorios.show', $relatorio)
                ->with('error', 'Somente relatórios com status EMITIDO podem ser impressos.');
        }

        $relatorio->load([
            'clienteSnapshot',
            'veiculoSnapshot',
            'finalidades',
            'compartimentos',
            'equipamentosUtilizados',
            'responsavelTecnico.profile',
        ]);

        // Extract finalidade enum values into array for view
        $relFinalidades = $relatorio->finalidades
            ->pluck('finalidade')
            ->map(fn($f) => $f->value)
            ->all();

        // Get latest measurement equipment for the report
        $medicaoEquipamentos = \App\Models\EquipamentoMedicao::getLatestByType();

        return view('relatorios.print', compact('relatorio', 'relFinalidades', 'medicaoEquipamentos'));
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
                        'tempo_minutos' => $capacidade !== null ? 60 : null,
                        'massa_vapor'   => null,   // displayed as NA in UI
                        'volume_ar'     => $capacidade !== null
                            ? round($capacidade * 20, 4) : null,
                        'neutralizante' => 'NA',

                        // Lacre fields are not used in this workflow
                        'lacre_entrada_numero' => null,
                        'lacre_saida_numero'   => null,

                        'observacao' => $data['observacao'] ?? null,
                    ]);
            }

            // Transition to EMITIDO when all compartments are fully filled.
            // A compartment is considered complete when both its volume and
            // its previous product have been provided (both required for SRD).
            if ($relatorio->status === StatusRelatorio::RASCUNHO) {
                $total    = $relatorio->compartimentos()->count();
                $completo = $relatorio->compartimentos()
                    ->whereNotNull('capacidade_litros')
                    ->whereNotNull('produto_anterior_nome')
                    ->count();

                if ($total > 0 && $completo === $total) {
                    $relatorio->update([
                        'status'     => StatusRelatorio::EMITIDO,
                        'emitido_em' => now(),
                    ]);
                }
            }
        });

        $mensagem = $relatorio->fresh()->status === StatusRelatorio::EMITIDO
            ? 'Relatório emitido com sucesso!'
            : 'Relatório salvo como rascunho. Preencha todos os compartimentos para emitir.';

        return redirect()
            ->route('relatorios.show', $relatorio)
            ->with('success', $mensagem);
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
            ->orderBy('marca')
            ->orderBy('modelo')
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

    public function destroy(RelatorioDescontaminacao $relatorio): RedirectResponse
    {
        $relatorio->delete();

        return redirect()->route('dashboard')->with('success', "OS #{$relatorio->numero_relatorio} excluída com sucesso.");
    }

    /**
     * Re-sync the client and vehicle snapshots of a report with the current
     * live data from the originating records.
     */
    public function refreshSnapshots(RelatorioDescontaminacao $relatorio): RedirectResponse
    {
        $ok = $this->snapshotService->refreshSnapshots($relatorio);

        if (! $ok) {
            return redirect()
                ->route('relatorios.edit', $relatorio)
                ->with('error', 'Não foi possível atualizar: cliente ou veículo original não encontrado.');
        }

        return redirect()
            ->route('relatorios.edit', $relatorio)
            ->with('success', 'Dados do cliente e veículo atualizados no relatório.');
    }
}

