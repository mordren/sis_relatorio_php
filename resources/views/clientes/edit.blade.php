@extends('layouts.app')

@section('title', 'Editar Cliente')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0"><i class="bi bi-pencil-square"></i> Editar Cliente</h4>
            <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Voltar à lista
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-person"></i>
                    {{ $cliente->nome_razao_social }}
                    <small class="text-muted fw-normal fs-6">— {{ $cliente->cpf_cnpj }}</small>
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('clientes.update', $cliente) }}">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="tipo_pessoa" class="form-label">Tipo de Pessoa <span class="text-danger">*</span></label>
                            <select class="form-select @error('tipo_pessoa') is-invalid @enderror"
                                    id="tipo_pessoa"
                                    name="tipo_pessoa"
                                    required>
                                <option value="">Selecione...</option>
                                @foreach(\App\Enums\TipoPessoa::cases() as $tipo)
                                    <option value="{{ $tipo->value }}"
                                        {{ old('tipo_pessoa', $cliente->tipo_pessoa->value) === $tipo->value ? 'selected' : '' }}>
                                        {{ $tipo->label() }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipo_pessoa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-8">
                            <label for="nome_razao_social" class="form-label">Nome / Razão Social <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('nome_razao_social') is-invalid @enderror"
                                   id="nome_razao_social"
                                   name="nome_razao_social"
                                   value="{{ old('nome_razao_social', $cliente->nome_razao_social) }}"
                                   required>
                            @error('nome_razao_social')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="cpf_cnpj" class="form-label">CPF / CNPJ <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('cpf_cnpj') is-invalid @enderror"
                                   id="cpf_cnpj"
                                   name="cpf_cnpj"
                                   value="{{ old('cpf_cnpj', $cliente->cpf_cnpj) }}"
                                   maxlength="20"
                                   required>
                            @error('cpf_cnpj')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Somente dígitos. PF: 11 dígitos / PJ: 14 dígitos.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="proprietario" class="form-label">Proprietário</label>
                            <input type="text"
                                   class="form-control @error('proprietario') is-invalid @enderror"
                                   id="proprietario"
                                   name="proprietario"
                                   value="{{ old('proprietario', $cliente->proprietario) }}"
                                   maxlength="200">
                            @error('proprietario')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email', $cliente->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="text"
                                   class="form-control @error('telefone') is-invalid @enderror"
                                   id="telefone"
                                   name="telefone"
                                   value="{{ old('telefone', $cliente->telefone) }}"
                                   maxlength="20">
                            @error('telefone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="endereco" class="form-label">Endereço</label>
                            <input type="text"
                                   class="form-control @error('endereco') is-invalid @enderror"
                                   id="endereco"
                                   name="endereco"
                                   value="{{ old('endereco', $cliente->endereco) }}">
                            @error('endereco')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input type="text"
                                   class="form-control @error('cidade') is-invalid @enderror"
                                   id="cidade"
                                   name="cidade"
                                   value="{{ old('cidade', $cliente->cidade) }}">
                            @error('cidade')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="estado" class="form-label">Estado (UF)</label>
                            <input type="text"
                                   class="form-control @error('estado') is-invalid @enderror"
                                   id="estado"
                                   name="estado"
                                   value="{{ old('estado', $cliente->estado) }}"
                                   maxlength="2"
                                   placeholder="SP">
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="ativo"
                                   name="ativo"
                                   value="1"
                                   {{ old('ativo', $cliente->ativo) ? 'checked' : '' }}>
                            <label class="form-check-label" for="ativo">Cliente ativo</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
