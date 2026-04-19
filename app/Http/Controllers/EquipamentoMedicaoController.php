<?php

namespace App\Http\Controllers;

use App\Models\EquipamentoMedicao;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EquipamentoMedicaoController extends Controller
{
    // Admin-only check
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!$request->user()?->is_admin) {
                abort(403, 'Acesso negado. Apenas administradores podem acessar equipamentos de medição.');
            }
            return $next($request);
        });
    }

    public function index(): View
    {
        $equipamentos = EquipamentoMedicao::latest()->paginate(20);
        return view('equipamentos_medicao.index', compact('equipamentos'));
    }

    public function create(): View
    {
        $tipos = ['detector', 'explosimetro', 'oximetro'];
        return view('equipamentos_medicao.create', compact('tipos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tipo' => ['required', 'in:detector,explosimetro,oximetro'],
            'numero_serie' => ['required', 'string', 'unique:equipamentos_medicao,numero_serie', 'max:100'],
            'data_calibracao' => ['nullable', 'date'],
            'observacao' => ['nullable', 'string', 'max:1000'],
            'ativo' => ['boolean'],
        ]);

        EquipamentoMedicao::create($validated);

        return redirect()
            ->route('equipamentos_medicao.index')
            ->with('success', 'Equipamento de medição cadastrado com sucesso!');
    }

    public function edit(EquipamentoMedicao $equipamento): View
    {
        $tipos = ['detector', 'explosimetro', 'oximetro'];
        return view('equipamentos_medicao.edit', compact('equipamento', 'tipos'));
    }

    public function update(Request $request, EquipamentoMedicao $equipamento): RedirectResponse
    {
        $validated = $request->validate([
            'tipo' => ['required', 'in:detector,explosimetro,oximetro'],
            'numero_serie' => ['required', 'string', 'unique:equipamentos_medicao,numero_serie,' . $equipamento->id, 'max:100'],
            'data_calibracao' => ['nullable', 'date'],
            'observacao' => ['nullable', 'string', 'max:1000'],
            'ativo' => ['boolean'],
        ]);

        $equipamento->update($validated);

        return redirect()
            ->route('equipamentos_medicao.index')
            ->with('success', 'Equipamento de medição atualizado com sucesso!');
    }

    public function destroy(EquipamentoMedicao $equipamento): RedirectResponse
    {
        $equipamento->delete();

        return redirect()
            ->route('equipamentos_medicao.index')
            ->with('success', 'Equipamento de medição deletado com sucesso!');
    }
}
