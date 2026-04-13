<?php

namespace App\Http\Controllers;

use App\Enums\FinalidadeRelatorio;
use App\Enums\ProcessoRelatorio;
use App\Http\Requests\StoreRelatorioRequest;
use App\Http\Requests\UpdateRelatorioRequest;
use App\Models\Cliente;
use App\Models\RelatorioCompartimento;
use App\Models\RelatorioDescontaminacao;
use App\Models\User;
use App\Models\Veiculo;
use App\Services\SnapshotService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RelatorioController extends Controller
{
    public function __construct(
        private readonly SnapshotService $snapshotService
    ) {}

    public function create(): View
    {
        $clientes = Cliente::where('ativo', true)->orderBy('nome_razao_social')->get();
        $veiculos = Veiculo::where('ativo', true)->orderBy('placa')->get();
        $responsaveis = User::orderBy('name')->get();
        $processos = ProcessoRelatorio::cases();
        $finalidades = FinalidadeRelatorio::cases();

        return view('relatorios.create', compact(
            'clientes',
            'veiculos',
            'responsaveis',
            'processos',
            'finalidades'
        ));
    }

    public function store(StoreRelatorioRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $cliente = Cliente::findOrFail($validated['cliente_id']);
        $veiculo = Veiculo::findOrFail($validated['veiculo_id']);

        $reportData = [
            'status' => 'RASCUNHO',
            'data_servico' => $validated['data_servico'],
            'responsavel_tecnico_id' => $validated['responsavel_tecnico_id'],
            'processo' => $validated['processo'],
            'observacoes' => $validated['observacoes'] ?? null,
            'lacre_entrada' => $validated['lacre_entrada'] ?? null,
            'lacre_saida' => $validated['lacre_saida'] ?? null,
            'criado_por_id' => $request->user()->id,
        ];

        $relatorio = $this->snapshotService->createFullReport(
            $reportData,
            $validated['finalidades'],
            $cliente,
            $veiculo,
        );

        return redirect()
            ->route('relatorios.show', $relatorio)
            ->with('success', 'Relatório criado com sucesso!');
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
        $processos = ProcessoRelatorio::cases();

        return view('relatorios.edit', compact('relatorio', 'responsaveis', 'processos'));
    }

    public function update(UpdateRelatorioRequest $request, RelatorioDescontaminacao $relatorio): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($relatorio, $validated) {
            $relatorio->update([
                'data_servico' => $validated['data_servico'],
                'responsavel_tecnico_id' => $validated['responsavel_tecnico_id'],
                'processo' => $validated['processo'],
                'observacoes' => $validated['observacoes'] ?? null,
                'lacre_entrada' => $validated['lacre_entrada'] ?? null,
                'lacre_saida' => $validated['lacre_saida'] ?? null,
            ]);

            $compartimentosInput = collect($validated['compartimentos'])->keyBy('id');

            // Phase 1: set all numbers to a safe temporary value (1_000_000 + id)
            // to avoid triggering the unique(relatorio_id, numero) constraint during updates.
            foreach ($compartimentosInput as $id => $data) {
                RelatorioCompartimento::where('id', $id)
                    ->where('relatorio_id', $relatorio->id)
                    ->update(['numero' => 1000000 + (int) $id]);
            }

            // Phase 2: write the final values
            foreach ($compartimentosInput as $id => $data) {
                RelatorioCompartimento::where('id', $id)
                    ->where('relatorio_id', $relatorio->id)
                    ->update([
                        'numero' => $data['numero'],
                        'capacidade_litros' => $data['capacidade_litros'] ?? null,
                        'produto_anterior_nome' => $data['produto_anterior_nome'] ?? null,
                        'numero_onu' => $data['numero_onu'] ?? null,
                        'classe_risco' => $data['classe_risco'] ?? null,
                        'pressao_vapor' => $data['pressao_vapor'] ?? null,
                        'tempo_minutos' => $data['tempo_minutos'] ?? null,
                        'massa_vapor' => $data['massa_vapor'] ?? null,
                        'volume_ar' => $data['volume_ar'] ?? null,
                        'neutralizante' => $data['neutralizante'] ?? null,
                        'lacre_entrada_numero' => $data['lacre_entrada_numero'] ?? null,
                        'lacre_saida_numero' => $data['lacre_saida_numero'] ?? null,
                        'observacao' => $data['observacao'] ?? null,
                    ]);
            }
        });

        return redirect()
            ->route('relatorios.show', $relatorio)
            ->with('success', 'Relatório atualizado com sucesso!');
    }
}
