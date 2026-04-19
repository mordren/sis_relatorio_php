@extends('layouts.app')

@section('title', 'Editar Veículo')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0"><i class="bi bi-pencil-square"></i> Editar Veículo</h4>
            <a href="{{ route('veiculos.index') }}" class="btn btn-outline-secondary btn-sm">
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
                    <i class="bi bi-truck"></i>
                    {{ strtoupper($veiculo->placa) }}
                    <small class="text-muted fw-normal fs-6">— {{ $veiculo->marca }} {{ $veiculo->modelo }}</small>
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('veiculos.update', $veiculo) }}">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="placa" class="form-label">Placa <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control text-uppercase @error('placa') is-invalid @enderror"
                                   id="placa"
                                   name="placa"
                                   value="{{ old('placa', $veiculo->placa) }}"
                                   maxlength="10"
                                   required>
                            @error('placa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="marca" class="form-label">Marca <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('marca') is-invalid @enderror"
                                   id="marca"
                                   name="marca"
                                   value="{{ old('marca', $veiculo->marca) }}"
                                   required>
                            @error('marca')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="modelo" class="form-label">Modelo <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('modelo') is-invalid @enderror"
                                   id="modelo"
                                   name="modelo"
                                   value="{{ old('modelo', $veiculo->modelo) }}"
                                   required>
                            @error('modelo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="ano" class="form-label">Ano de Fabricação</label>
                            <input type="number"
                                   class="form-control @error('ano') is-invalid @enderror"
                                   id="ano"
                                   name="ano"
                                   value="{{ old('ano', $veiculo->ano) }}"
                                   min="1950"
                                   max="{{ date('Y') + 1 }}">
                            @error('ano')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="tipo_veiculo" class="form-label">Tipo de Veículo <span class="text-danger">*</span></label>
                            <select class="form-select @error('tipo_veiculo') is-invalid @enderror"
                                    id="tipo_veiculo"
                                    name="tipo_veiculo"
                                    required>
                                <option value="">Selecione...</option>
                                @foreach($tiposVeiculo as $tipo)
                                    <option value="{{ $tipo }}"
                                        {{ old('tipo_veiculo', $veiculo->tipo_veiculo) === $tipo ? 'selected' : '' }}>
                                        {{ ucfirst(strtolower($tipo)) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipo_veiculo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="numero_compartimentos" class="form-label">Nº de Compartimentos <span class="text-danger">*</span></label>
                            <input type="number"
                                   class="form-control @error('numero_compartimentos') is-invalid @enderror"
                                   id="numero_compartimentos"
                                   name="numero_compartimentos"
                                   value="{{ old('numero_compartimentos', $veiculo->numero_compartimentos) }}"
                                   min="1"
                                   required>
                            @error('numero_compartimentos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="proprietario_id" class="form-label">Proprietário</label>
                        <select class="form-select @error('proprietario_id') is-invalid @enderror"
                                id="proprietario_id"
                                name="proprietario_id">
                            <option value="">Sem proprietário vinculado</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}"
                                    {{ old('proprietario_id', $veiculo->proprietario_id) == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->nome_razao_social }} — {{ $cliente->cpf_cnpj }}
                                </option>
                            @endforeach
                        </select>
                        @error('proprietario_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="ativo"
                                   name="ativo"
                                   value="1"
                                   {{ old('ativo', $veiculo->ativo) ? 'checked' : '' }}>
                            <label class="form-check-label" for="ativo">Veículo ativo</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('veiculos.index') }}" class="btn btn-outline-secondary">
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
