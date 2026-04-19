@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-people-fill"></i> Clientes</h2>
    <a href="{{ route('clientes.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus"></i> Novo Cliente
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
        @if($clientes->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-people fs-1"></i>
                <p class="mt-2">Nenhum cliente cadastrado.</p>
                <a href="{{ route('clientes.create') }}" class="btn btn-outline-primary btn-sm">
                    Cadastrar primeiro cliente
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nome / Razão Social</th>
                            <th>CPF / CNPJ</th>
                            <th>Tipo</th>
                            <th>Cidade / UF</th>
                            <th>Telefone</th>
                            <th>Situação</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientes as $cliente)
                        <tr>
                            <td class="fw-medium">{{ $cliente->nome_razao_social }}</td>
                            <td class="text-nowrap">{{ $cliente->cpf_cnpj }}</td>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ $cliente->tipo_pessoa->label() }}
                                </span>
                            </td>
                            <td>
                                @if($cliente->cidade)
                                    {{ $cliente->cidade }}{{ $cliente->estado ? '/' . $cliente->estado : '' }}
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $cliente->telefone ?: '—' }}</td>
                            <td>
                                @if($cliente->ativo)
                                    <span class="badge bg-success">Ativo</span>
                                @else
                                    <span class="badge bg-danger">Inativo</span>
                                @endif
                            </td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('clientes.edit', $cliente) }}"
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

            @if($clientes->hasPages())
                <div class="px-3 py-2">
                    {{ $clientes->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
