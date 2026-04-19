<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVeiculoRequest;
use App\Http\Requests\UpdateVeiculoRequest;
use App\Models\Cliente;
use App\Models\Veiculo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VeiculoController extends Controller
{
    /** Fixed options for vehicle type. */
    public const TIPOS_VEICULO = ['SEMIRREBOQUE', 'CAMINHAO', 'REBOCADO'];

    public function index(): View
    {
        $veiculos = Veiculo::with('proprietario')
            ->orderBy('placa')
            ->paginate(20);

        return view('veiculos.index', compact('veiculos'));
    }

    public function create(Request $request): View
    {
        $clientes          = Cliente::where('ativo', true)->orderBy('nome_razao_social')->get();
        $activeClientCount = $clientes->count();
        $tiposVeiculo      = self::TIPOS_VEICULO;

        // Context passed when coming from the report creation flow
        $requestedClienteId = $request->integer('cliente_id') ?: null;
        $returnTo           = $request->input('return_to');        // e.g. 'relatorios_create'
        $returnClienteId    = $request->integer('return_cliente_id') ?: null;

        return view('veiculos.create', compact(
            'clientes',
            'activeClientCount',
            'tiposVeiculo',
            'requestedClienteId',
            'returnTo',
            'returnClienteId'
        ));
    }

    public function store(StoreVeiculoRequest $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validated();

        $veiculo = Veiculo::create([
            'placa'                 => $validated['placa'],
            'modelo'                => $validated['modelo'],
            'marca'                 => $validated['marca'],
            'ano'                   => $validated['ano'] ?? null,
            'tipo_veiculo'          => $validated['tipo_veiculo'],
            'numero_compartimentos' => $validated['numero_compartimentos'],
            'proprietario_id'       => $validated['proprietario_id'] ?? null,
            'ativo'                 => $validated['ativo'] ?? true,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'id'                    => $veiculo->id,
                'text'                  => $veiculo->placa . ' — ' . $veiculo->marca . ' ' . $veiculo->modelo,
                'numero_compartimentos' => $veiculo->numero_compartimentos,
            ], 201);
        }

        // If created from the report flow, redirect back to report creation
        // preserving the selected client and pre-selecting the new vehicle.
        $returnTo        = $request->input('return_to');
        $returnClienteId = $request->input('return_cliente_id');

        if ($returnTo === 'relatorios_create' && $returnClienteId) {
            return redirect(
                route('relatorios.create') . '?cliente_id=' . $returnClienteId . '&new_veiculo_id=' . $veiculo->id
            )->with('success', 'Veículo cadastrado com sucesso! Selecione-o abaixo.');
        }

        return redirect()
            ->route('veiculos.create')
            ->with('success', 'Veículo cadastrado com sucesso!');
    }

    public function edit(Veiculo $veiculo): View
    {
        $clientes     = Cliente::where('ativo', true)->orderBy('nome_razao_social')->get();
        $tiposVeiculo = self::TIPOS_VEICULO;

        return view('veiculos.edit', compact('veiculo', 'clientes', 'tiposVeiculo'));
    }

    public function update(UpdateVeiculoRequest $request, Veiculo $veiculo): RedirectResponse
    {
        $validated = $request->validated();

        $veiculo->update([
            'placa'                 => $validated['placa'],
            'modelo'                => $validated['modelo'],
            'marca'                 => $validated['marca'],
            'ano'                   => $validated['ano'] ?? null,
            'tipo_veiculo'          => $validated['tipo_veiculo'],
            'numero_compartimentos' => $validated['numero_compartimentos'],
            'proprietario_id'       => $validated['proprietario_id'] ?? null,
            'ativo'                 => isset($validated['ativo']) ? (bool) $validated['ativo'] : false,
        ]);

        return redirect()
            ->route('veiculos.index')
            ->with('success', 'Veículo atualizado com sucesso!');
    }
}

