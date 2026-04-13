@extends('layouts.app')

@section('title', 'Cadastrar Cliente')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-person-plus"></i> Cadastrar Cliente</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('clientes.store') }}">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="tipo_pessoa" class="form-label">Tipo de Pessoa <span class="text-danger">*</span></label>
                            <select class="form-select @error('tipo_pessoa') is-invalid @enderror"
                                    id="tipo_pessoa"
                                    name="tipo_pessoa"
                                    required>
                                <option value="">Selecione...</option>
                                @foreach(\App\Enums\TipoPessoa::cases() as $tipo)
                                    <option value="{{ $tipo->value }}" {{ old('tipo_pessoa') === $tipo->value ? 'selected' : '' }}>
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
                                   value="{{ old('nome_razao_social') }}"
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
                                   value="{{ old('cpf_cnpj') }}"
                                   maxlength="14"
                                   required>
                            @error('cpf_cnpj')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text" id="cpf_cnpj_help">
                                Somente dígitos. PF: 11 dígitos / PJ: 14 dígitos.
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}">
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
                                   value="{{ old('telefone') }}"
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
                                   value="{{ old('endereco') }}">
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
                                   value="{{ old('cidade') }}">
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
                                   value="{{ old('estado') }}"
                                   maxlength="2"
                                   placeholder="SP">
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Cadastrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
