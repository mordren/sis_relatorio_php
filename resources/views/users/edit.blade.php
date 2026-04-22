@extends('layouts.app')

@section('title', 'Editar Usuário — ' . $user->name)
@section('page-title', 'Editar Usuário')

@section('content')
<div class="mb-4">
    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
</div>

<div class="card-modern" style="max-width: 680px">
    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf @method('PUT')

        <h6 class="fw-bold mb-3 text-primary"><i class="bi bi-person-fill me-2"></i>Dados de Acesso</h6>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Nome <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                       name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">E-mail <span class="text-danger">*</span></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Nova Senha <small class="text-muted">(deixe em branco para manter)</small></label>
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                       name="password" autocomplete="new-password">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Confirmar Nova Senha</label>
                <input type="password" class="form-control" name="password_confirmation">
            </div>
        </div>

        <h6 class="fw-bold mb-3 text-primary"><i class="bi bi-shield-check me-2"></i>Permissões</h6>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Tipo de Usuário</label>
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" name="is_admin" id="is_admin"
                           value="1" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}
                           {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                    <label class="form-check-label" for="is_admin">Administrador</label>
                    @if($user->id === auth()->id())
                        {{-- Keep current value when disabled --}}
                        @if($user->is_admin)
                            <input type="hidden" name="is_admin" value="1">
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Status</label>
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" name="ativo" id="ativo"
                           value="1" {{ old('ativo', $user->profile?->ativo ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="ativo">Ativo</label>
                </div>
            </div>
        </div>

        <h6 class="fw-bold mb-3 text-primary"><i class="bi bi-person-badge me-2"></i>Perfil Profissional</h6>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Cargo</label>
                <input type="text" class="form-control @error('cargo') is-invalid @enderror"
                       name="cargo" value="{{ old('cargo', $user->profile?->cargo) }}">
                @error('cargo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Registro Profissional</label>
                <input type="text" class="form-control @error('registro_profissional') is-invalid @enderror"
                       name="registro_profissional" value="{{ old('registro_profissional', $user->profile?->registro_profissional) }}">
                @error('registro_profissional')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Telefone</label>
                <input type="text" class="form-control @error('telefone') is-invalid @enderror"
                       name="telefone" value="{{ old('telefone', $user->profile?->telefone) }}" maxlength="20">
                @error('telefone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg"></i> Salvar Alterações
            </button>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
