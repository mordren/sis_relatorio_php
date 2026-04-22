@extends('layouts.app')

@section('title', 'Gerenciamento de Usuários')
@section('page-title', 'Gerenciamento de Usuários')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div></div>
    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-person-plus-fill"></i> Novo Usuário
    </a>
</div>

<div class="card-modern">
    <div class="table-responsive table-modern">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Tipo</th>
                    <th>Cargo</th>
                    <th>Status</th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-person-circle text-secondary fs-5"></i>
                            <strong>{{ $user->name }}</strong>
                        </div>
                    </td>
                    <td class="text-muted">{{ $user->email }}</td>
                    <td>
                        @if($user->is_admin)
                            <span class="badge bg-danger">Administrador</span>
                        @else
                            <span class="badge bg-secondary">Usuário</span>
                        @endif
                    </td>
                    <td>{{ $user->profile?->cargo ?? '—' }}</td>
                    <td>
                        @if($user->profile?->ativo ?? true)
                            <span class="badge bg-success">Ativo</span>
                        @else
                            <span class="badge bg-warning text-dark">Inativo</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        @if($user->id !== auth()->id())
                        <form method="POST" action="{{ route('users.destroy', $user) }}" class="d-inline"
                              onsubmit="return confirm('Confirmar exclusão do usuário {{ addslashes($user->name) }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Nenhum usuário encontrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="mt-3 px-2">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
