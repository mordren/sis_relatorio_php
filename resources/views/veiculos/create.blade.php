@extends('layouts.app')

@section('title', 'Cadastrar Veículo')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        @if($activeClientCount > 0)
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i>
                {{ $activeClientCount }} {{ $activeClientCount === 1 ? 'cliente ativo disponível' : 'clientes ativos disponíveis' }} para associar como proprietário.
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
                                   style="text-transform: uppercase"
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
                        <div class="col-md-4">
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

                        <div class="col-md-4">
                            <label for="proprietario_id" class="form-label">Proprietário</label>
                            <select class="form-select @error('proprietario_id') is-invalid @enderror"
                                    id="proprietario_id"
                                    name="proprietario_id">
                                <option value="">Nenhum</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ old('proprietario_id') == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->nome_razao_social }} ({{ $cliente->cpf_cnpj }})
                                    </option>
                                @endforeach
                            </select>
                            @error('proprietario_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Compartimentos --}}
                    <fieldset class="mb-4">
                        <legend class="h6 border-bottom pb-2 mb-3">
                            <i class="bi bi-layout-split"></i> Compartimentos <span class="text-danger">*</span>
                        </legend>

                        @error('compartimentos')
                            <div class="alert alert-danger py-2">{{ $message }}</div>
                        @enderror

                        <div id="compartimentos-container">
                            @php
                                $oldCompartimentos = old('compartimentos', [['numero' => 1, 'capacidade_litros' => '', 'produto_atual_id' => '']]);
                            @endphp

                            @foreach($oldCompartimentos as $ci => $oldComp)
                            <div class="row mb-2 align-items-start compartimento-row">
                                <div class="col-md-2">
                                    <label class="form-label">Nº <span class="text-danger">*</span></label>
                                    <input type="number"
                                           class="form-control @error("compartimentos.{$ci}.numero") is-invalid @enderror"
                                           name="compartimentos[{{ $ci }}][numero]"
                                           value="{{ $oldComp['numero'] ?? ($ci + 1) }}"
                                           min="1" required>
                                    @error("compartimentos.{$ci}.numero")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Capacidade (L) <span class="text-danger">*</span></label>
                                    <input type="number"
                                           class="form-control @error("compartimentos.{$ci}.capacidade_litros") is-invalid @enderror"
                                           name="compartimentos[{{ $ci }}][capacidade_litros]"
                                           value="{{ $oldComp['capacidade_litros'] ?? '' }}"
                                           step="0.01" min="0.01" required>
                                    @error("compartimentos.{$ci}.capacidade_litros")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Produto Atual</label>
                                    <select class="form-select @error("compartimentos.{$ci}.produto_atual_id") is-invalid @enderror"
                                            name="compartimentos[{{ $ci }}][produto_atual_id]">
                                        <option value="">Nenhum / Vazio</option>
                                        @foreach($produtos as $produto)
                                            <option value="{{ $produto->id }}"
                                                {{ ($oldComp['produto_atual_id'] ?? '') == $produto->id ? 'selected' : '' }}>
                                                {{ $produto->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error("compartimentos.{$ci}.produto_atual_id")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-2 d-flex align-items-end pb-1">
                                    @if($ci > 0)
                                        <button type="button" class="btn btn-outline-danger btn-sm remove-compartimento">
                                            <i class="bi bi-trash"></i> Remover
                                        </button>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-compartimento">
                            <i class="bi bi-plus"></i> Adicionar Compartimento
                        </button>
                    </fieldset>

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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('compartimentos-container');
    const addBtn = document.getElementById('add-compartimento');
    let index = {{ count($oldCompartimentos) }};

    const produtoOptions = `
        <option value="">Nenhum / Vazio</option>
        @foreach($produtos as $produto)
            <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
        @endforeach
    `;

    addBtn.addEventListener('click', function () {
        const row = document.createElement('div');
        row.className = 'row mb-2 align-items-start compartimento-row';
        row.innerHTML = `
            <div class="col-md-2">
                <label class="form-label">Nº <span class="text-danger">*</span></label>
                <input type="number" class="form-control"
                       name="compartimentos[${index}][numero]"
                       value="${index + 1}" min="1" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Capacidade (L) <span class="text-danger">*</span></label>
                <input type="number" class="form-control"
                       name="compartimentos[${index}][capacidade_litros]"
                       step="0.01" min="0.01" required>
            </div>
            <div class="col-md-5">
                <label class="form-label">Produto Atual</label>
                <select class="form-select" name="compartimentos[${index}][produto_atual_id]">
                    ${produtoOptions}
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end pb-1">
                <button type="button" class="btn btn-outline-danger btn-sm remove-compartimento">
                    <i class="bi bi-trash"></i> Remover
                </button>
            </div>
        `;
        container.appendChild(row);
        index++;
    });

    container.addEventListener('click', function (e) {
        const btn = e.target.closest('.remove-compartimento');
        if (btn) {
            btn.closest('.compartimento-row').remove();
        }
    });
});
</script>
@endpush
