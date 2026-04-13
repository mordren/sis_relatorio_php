@extends('layouts.app')

@section('title', 'Cadastrar Veículo')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        @if($activeClientCount > 0)
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i>
                {{ $activeClientCount }} {{ $activeClientCount === 1 ? 'cliente ativo disponível' : 'clientes ativos disponíveis' }} para associar como proprietário.
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-truck"></i> Cadastrar Veículo</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('veiculos.store') }}">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="placa" class="form-label">Placa <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('placa') is-invalid @enderror"
                                   id="placa"
                                   name="placa"
                                   value="{{ old('placa') }}"
                                   maxlength="10"
                                   style="text-transform:uppercase"
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
                                   value="{{ old('marca') }}"
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
                                   value="{{ old('modelo') }}"
                                   required>
                            @error('modelo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="ano" class="form-label">Ano</label>
                            <input type="number"
                                   class="form-control @error('ano') is-invalid @enderror"
                                   id="ano"
                                   name="ano"
                                   value="{{ old('ano') }}"
                                   min="1900"
                                   max="{{ date('Y') + 2 }}">
                            @error('ano')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="tipo_veiculo" class="form-label">Tipo de Veículo</label>
                            <input type="text"
                                   class="form-control @error('tipo_veiculo') is-invalid @enderror"
                                   id="tipo_veiculo"
                                   name="tipo_veiculo"
                                   value="{{ old('tipo_veiculo') }}"
                                   placeholder="Ex: Caminhão Tanque">
                            @error('tipo_veiculo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <label for="numero_compartimentos" class="form-label">
                                Nº de Compartimentos <span class="text-danger">*</span>
                            </label>
                            <input type="number"
                                   class="form-control @error('numero_compartimentos') is-invalid @enderror"
                                   id="numero_compartimentos"
                                   name="numero_compartimentos"
                                   value="{{ old('numero_compartimentos', 1) }}"
                                   min="1"
                                   max="99"
                                   required>
                            @error('numero_compartimentos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="proprietario_id" class="form-label">Proprietário</label>
                            <select class="form-select @error('proprietario_id') is-invalid @enderror"
                                    id="proprietario_id"
                                    name="proprietario_id">
                                <option value="">Nenhum</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ old('proprietario_id') == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->nome_razao_social }}
                                    </option>
                                @endforeach
                            </select>
                            @error('proprietario_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
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