<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVeiculoRequest;
use App\Models\Cliente;
use App\Models\Veiculo;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VeiculoController extends Controller
{
    public function create(): View
    {
        $clientes = Cliente::where('ativo', true)->orderBy('nome_razao_social')->get();
        $activeClientCount = $clientes->count();

        return view('veiculos.create', compact('clientes', 'activeClientCount'));
    }

    public function store(StoreVeiculoRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Veiculo::create([
            'placa' => $validated['placa'],
            'modelo' => $validated['modelo'],
            'marca' => $validated['marca'],
            'ano' => $validated['ano'] ?? null,
            'tipo_veiculo' => $validated['tipo_veiculo'] ?? null,
            'numero_compartimentos' => $validated['numero_compartimentos'],
            'proprietario_id' => $validated['proprietario_id'] ?? null,
            'ativo' => $validated['ativo'] ?? true,
        ]);

        return redirect()
            ->route('veiculos.create')
            ->with('success', 'Veículo cadastrado com sucesso!');
    }
}

