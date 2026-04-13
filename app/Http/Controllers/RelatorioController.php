<?php

namespace App\Http\Controllers;

use App\Enums\FinalidadeRelatorio;
use App\Enums\ProcessoRelatorio;
use App\Http\Requests\StoreRelatorioRequest;
use App\Models\Cliente;
use App\Models\RelatorioDescontaminacao;
use App\Models\User;
use App\Models\Veiculo;
use App\Services\SnapshotService;
use Illuminate\Http\RedirectResponse;
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

        // Generate next report number suggestion
        $lastReport = RelatorioDescontaminacao::orderByDesc('id')->first();
        $nextNumber = $lastReport
            ? 'REL-' . str_pad((intval(str_replace('REL-', '', $lastReport->numero_relatorio)) + 1), 6, '0', STR_PAD_LEFT)
            : 'REL-000001';

        return view('relatorios.create', compact(
            'clientes',
            'veiculos',
            'responsaveis',
            'processos',
            'finalidades',
            'nextNumber'
        ));
    }

    public function store(StoreRelatorioRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $cliente = Cliente::findOrFail($validated['cliente_id']);
        $veiculo = Veiculo::findOrFail($validated['veiculo_id']);

        $reportData = [
            'numero_relatorio' => $validated['numero_relatorio'],
            'status' => 'RASCUNHO',
            'data_servico' => $validated['data_servico'],
            'responsavel_tecnico_id' => $validated['responsavel_tecnico_id'],
            'processo' => $validated['processo'],
            'observacoes' => $validated['observacoes'] ?? null,
            'lacre_entrada' => $validated['lacre_entrada'] ?? null,
            'lacre_saida' => $validated['lacre_saida'] ?? null,
            'criado_por_id' => $request->user()->id,
        ];

        $this->snapshotService->createFullReport(
            $reportData,
            $validated['finalidades'],
            $cliente,
            $veiculo,
        );

        return redirect()
            ->route('dashboard')
            ->with('success', 'Relatório criado com sucesso!');
    }
}
