@extends('layouts.app')

@section('title', 'Cadastrar Veículo')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        {{-- Alerta com contagem de clientes ativos --}}
        @if($activeClientCount > 0)
            <div class="alert alert-info alert-dismissible fade show rounded-4 d-flex align-items-center">
                <i class="bi bi-info-circle-fill me-3 fs-5"></i>
                <span>
                    <strong>{{ $activeClientCount }}</strong> 
                    {{ $activeClientCount === 1 ? 'cliente ativo disponível' : 'clientes ativos disponíveis' }} 
                    para associar como proprietário.
                </span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-3 fs-5"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card card-modern">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-truck me-2"></i> Cadastrar Veículo
                </h5>
            </div>
            <div class="card-body px-4 pb-4">
                <form method="POST" action="{{ route('veiculos.store') }}">
                    @csrf

                    {{-- Navegação contextual (retorno ao fluxo de criação de relatório) --}}
                    <input type="hidden" name="return_to" value="{{ $returnTo }}">
                    <input type="hidden" name="return_cliente_id" value="{{ $returnClienteId }}">

                    <div class="row g-3 mb-4">
                        {{-- Placa --}}
                        <div class="col-md-4">
                            <label for="placa" class="form-label fw-medium">Placa <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('placa') is-invalid @enderror"
                                   id="placa"
                                   name="placa"
                                   value="{{ old('placa') }}"
                                   maxlength="10"
                                   style="text-transform:uppercase"
                                   placeholder="ABC1D23"
                                   required>
                            @error('placa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Marca --}}
                        <div class="col-md-4">
                            <label for="marca" class="form-label fw-medium">Marca <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('marca') is-invalid @enderror"
                                   id="marca"
                                   name="marca"
                                   value="{{ old('marca') }}"
                                   placeholder="Ex: Volvo"
                                   required>
                            @error('marca')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Modelo --}}
                        <div class="col-md-4">
                            <label for="modelo" class="form-label fw-medium">Modelo <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('modelo') is-invalid @enderror"
                                   id="modelo"
                                   name="modelo"
                                   value="{{ old('modelo') }}"
                                   placeholder="Ex: FH 540"
                                   required>
                            @error('modelo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        {{-- Ano --}}
                        <div class="col-md-3">
                            <label for="ano" class="form-label fw-medium">Ano</label>
                            <input type="number"
                                   class="form-control @error('ano') is-invalid @enderror"
                                   id="ano"
                                   name="ano"
                                   value="{{ old('ano') }}"
                                   min="1900"
                                   max="{{ date('Y') + 2 }}"
                                   placeholder="{{ date('Y') }}">
                            @error('ano')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tipo de Veículo --}}
                        <div class="col-md-4">
                            <label for="tipo_veiculo" class="form-label fw-medium">Tipo de Veículo <span class="text-danger">*</span></label>
                            <select class="form-select @error('tipo_veiculo') is-invalid @enderror"
                                    id="tipo_veiculo"
                                    name="tipo_veiculo"
                                    required>
                                <option value="">Selecione...</option>
                                @foreach($tiposVeiculo as $tipo)
                                    <option value="{{ $tipo }}" {{ old('tipo_veiculo') === $tipo ? 'selected' : '' }}>
                                        {{ $tipo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipo_veiculo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Número de Compartimentos --}}
                        <div class="col-md-2">
                            <label for="numero_compartimentos" class="form-label fw-lower">
                                Nº Compart. <span class="text-danger">*</span>
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

                        {{-- Proprietário (Cliente) --}}
                        <div class="col-md-3">
                            <label for="proprietario_id" class="form-label fw-medium">Proprietário</label>
                            <select class="form-select @error('proprietario_id') is-invalid @enderror"
                                    id="proprietario_id"
                                    name="proprietario_id">
                                <option value="">Nenhum (opcional)</option>
                                @foreach($clientes as $cliente)
                                    @php
                                        $selected = old('proprietario_id', $requestedClienteId) == $cliente->id ? 'selected' : '';
                                    @endphp
                                    <option value="{{ $cliente->id }}" {{ $selected }}>
                                        {{ $cliente->nome_razao_social }} ({{ $cliente->cpf_cnpj }})
                                    </option>
                                @endforeach
                            </select>
                            @error('proprietario_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> O proprietário pode ser associado depois.
                            </div>
                        </div>
                    </div>

                    {{-- Botões de ação --}}
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-2 border-top">
                        <div>
                            @if($returnTo === 'relatorios_create' && $returnClienteId)
                                <a href="{{ route('relatorios.create') }}?cliente_id={{ $returnClienteId }}" class="btn btn-outline-secondary rounded-pill">
                                    <i class="bi bi-arrow-left me-1"></i> Voltar ao Relatório
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-pill">
                                    <i class="bi bi-arrow-left me-1"></i> Voltar ao Início
                                </a>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-check-lg me-1"></i> Cadastrar Veículo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection