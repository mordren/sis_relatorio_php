@extends('layouts.app')

@section('title', 'Veículos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-truck"></i> Veículos</h2>
    <a href="{{ route('veiculos.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Novo Veículo
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-body p-0">
        @if($veiculos->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-truck fs-1"></i>
                <p class="mt-2">Nenhum veículo cadastrado.</p>
                <a href="{{ route('veiculos.create') }}" class="btn btn-outline-primary btn-sm">
                    Cadastrar primeiro veículo
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Placa</th>
                            <th>Marca / Modelo</th>
                            <th>Ano</th>
                            <th>Tipo</th>
                            <th class="text-center">Compart.</th>
                            <th>Nº Equip.</th>
                            <th>Proprietário</th>
                            <th>Situação</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($veiculos as $veiculo)
                        <tr>
                            <td class="fw-medium text-uppercase">{{ $veiculo->placa }}</td>
                            <td>{{ $veiculo->marca }} / {{ $veiculo->modelo }}</td>
                            <td>{{ $veiculo->ano ?: '—' }}</td>
                            <td>
                                <span class="badge bg-secondary text-uppercase">
                                    {{ $veiculo->tipo_veiculo }}
                                </span>
                            </td>
                            <td class="text-center">{{ $veiculo->numero_compartimentos }}</td>
                            <td>{{ $veiculo->numero_equipamento ?: '—' }}</td>
                            <td>{{ $veiculo->proprietario?->nome_razao_social ?? '—' }}</td>
                            <td>
                                @if($veiculo->ativo)
                                    <span class="badge bg-success">Ativo</span>
                                @else
                                    <span class="badge bg-danger">Inativo</span>
                                @endif
                            </td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('veiculos.edit', $veiculo) }}"
                                   class="btn btn-outline-primary btn-sm"
                                   title="Editar">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($veiculos->hasPages())
                <div class="px-3 py-2">
                    {{ $veiculos->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
