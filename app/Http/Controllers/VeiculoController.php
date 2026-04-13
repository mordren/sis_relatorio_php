<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVeiculoRequest;
use App\Models\Cliente;
use App\Models\ProdutoTransportado;
use App\Models\Veiculo;
use App\Models\VeiculoCompartimento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class VeiculoController extends Controller
{
    public function create(): View
    {
        $clientes = Cliente::where('ativo', true)->orderBy('nome_razao_social')->get();
        $activeClientCount = $clientes->count();
        $produtos = ProdutoTransportado::where('ativo', true)->orderBy('nome')->get();

        return view('veiculos.create', compact('clientes', 'activeClientCount', 'produtos'));
    }

    public function store(StoreVeiculoRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            $veiculo = Veiculo::create([
                'placa' => $validated['placa'],
                'modelo' => $validated['modelo'],
                'marca' => $validated['marca'],
                'ano' => $validated['ano'] ?? null,
                'tipo_veiculo' => $validated['tipo_veiculo'] ?? null,
                'proprietario_id' => $validated['proprietario_id'] ?? null,
                'ativo' => $validated['ativo'] ?? true,
            ]);

            foreach ($validated['compartimentos'] as $comp) {
                VeiculoCompartimento::create([
                    'veiculo_id' => $veiculo->id,
                    'numero' => $comp['numero'],
                    'capacidade_litros' => $comp['capacidade_litros'],
                    'produto_atual_id' => $comp['produto_atual_id'] ?? null,
                ]);
            }
        });

        return redirect()
            ->route('veiculos.create')
            ->with('success', 'Veículo cadastrado com sucesso!');
    }
}
