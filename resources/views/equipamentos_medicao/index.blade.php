@extends('layouts.app')

@section('title', 'Equipamentos de Medição')
@section('page-title', 'Equipamentos de Medição')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div></div>
    <a href="{{ route('equipamentos_medicao.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> Novo Equipamento
    </a>
</div>

<div class="card-modern">
    <div class="table-responsive table-modern">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Tipo</th>
                    <th>Nº Série</th>
                    <th>Data Calibração</th>
                    <th>Observação</th>
                    <th>Status</th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($equipamentos as $eq)
                <tr>
                    <td>{{ $eq->getTypeLabel() }}</td>
                    <td><strong>{{ $eq->numero_serie }}</strong></td>
                    <td>{{ $eq->data_calibracao?->format('d/m/Y') ?? '—' }}</td>
                    <td class="text-muted">{{ $eq->observacao ?? '—' }}</td>
                    <td>
                        @if($eq->ativo)
                            <span class="badge bg-success">Ativo</span>
                        @else
                            <span class="badge bg-warning text-dark">Inativo</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('equipamentos_medicao.edit', $eq) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form method="POST" action="{{ route('equipamentos_medicao.destroy', $eq) }}" class="d-inline"
                              onsubmit="return confirm('Confirmar exclusão do equipamento {{ addslashes($eq->numero_serie) }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Nenhum equipamento registrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($equipamentos->hasPages())
    <div class="mt-3 px-2">
        {{ $equipamentos->links() }}
    </div>
    @endif
</div>
@endsection
