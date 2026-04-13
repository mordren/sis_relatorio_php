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
        Veiculo::create($request->validated());

        return redirect()
            ->route('veiculos.create')
            ->with('success', 'Veículo cadastrado com sucesso!');
    }
}
