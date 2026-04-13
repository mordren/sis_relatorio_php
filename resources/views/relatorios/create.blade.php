@extends('layouts.app')

@section('title', 'Novo Relatório de Descontaminação')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-file-earmark-plus"></i> Novo Relatório de Descontaminação
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('relatorios.store') }}" id="relatorioForm">
                    @csrf

                    {{-- Dados do Relatório --}}
                    <fieldset class="mb-4">
                        <legend class="h6 border-bottom pb-2 mb-3">
                            <i class="bi bi-file-text"></i> Dados do Relatório
                        </legend>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="numero_relatorio" class="form-label">Nº do Relatório <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('numero_relatorio') is-invalid @enderror"
                                       id="numero_relatorio"
                                       name="numero_relatorio"
                                       value="{{ old('numero_relatorio', $nextNumber) }}"
                                       required>
                                @error('numero_relatorio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="data_servico" class="form-label">Data do Serviço <span class="text-danger">*</span></label>
                                <input type="date"
                                       class="form-control @error('data_servico') is-invalid @enderror"
                                       id="data_servico"
                                       name="data_servico"
                                       value="{{ old('data_servico', date('Y-m-d')) }}"
                                       required>
                                @error('data_servico')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="processo" class="form-label">Processo <span class="text-danger">*</span></label>
                                <select class="form-select @error('processo') is-invalid @enderror"
                                        id="processo"
                                        name="processo"
                                        required>
                                    <option value="">Selecione...</option>
                                    @foreach($processos as $processo)
                                        <option value="{{ $processo->value }}" {{ old('processo') === $processo->value ? 'selected' : '' }}>
                                            {{ $processo->label() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('processo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="responsavel_tecnico_id" class="form-label">Responsável Técnico <span class="text-danger">*</span></label>
                                <select class="form-select @error('responsavel_tecnico_id') is-invalid @enderror"
                                        id="responsavel_tecnico_id"
                                        name="responsavel_tecnico_id"
                                        required>
                                    <option value="">Selecione...</option>
                                    @foreach($responsaveis as $resp)
                                        <option value="{{ $resp->id }}" {{ old('responsavel_tecnico_id') == $resp->id ? 'selected' : '' }}>
                                            {{ $resp->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('responsavel_tecnico_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="lacre_entrada" class="form-label">Lacre de Entrada</label>
                                <input type="text"
                                       class="form-control @error('lacre_entrada') is-invalid @enderror"
                                       id="lacre_entrada"
                                       name="lacre_entrada"
                                       value="{{ old('lacre_entrada') }}">
                                @error('lacre_entrada')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="lacre_saida" class="form-label">Lacre de Saída</label>
                                <input type="text"
                                       class="form-control @error('lacre_saida') is-invalid @enderror"
                                       id="lacre_saida"
                                       name="lacre_saida"
                                       value="{{ old('lacre_saida') }}">
                                @error('lacre_saida')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- Cliente --}}
                    <fieldset class="mb-4">
                        <legend class="h6 border-bottom pb-2 mb-3">
                            <i class="bi bi-person"></i> Cliente
                        </legend>

                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="cliente_id" class="form-label">Selecionar Cliente <span class="text-danger">*</span></label>
                                <select class="form-select @error('cliente_id') is-invalid @enderror"
                                        id="cliente_id"
                                        name="cliente_id"
                                        required>
                                    <option value="">Selecione um cliente...</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                            {{ $cliente->nome_razao_social }} - {{ $cliente->cpf_cnpj }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cliente_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Os dados do cliente serão congelados no momento da criação do relatório.
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <a href="{{ route('clientes.create') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-plus"></i> Cadastrar Novo
                                </a>
                            </div>
                        </div>
                    </fieldset>

                    {{-- Veículo --}}
                    <fieldset class="mb-4">
                        <legend class="h6 border-bottom pb-2 mb-3">
                            <i class="bi bi-truck"></i> Veículo
                        </legend>

                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="veiculo_id" class="form-label">Selecionar Veículo <span class="text-danger">*</span></label>
                                <select class="form-select @error('veiculo_id') is-invalid @enderror"
                                        id="veiculo_id"
                                        name="veiculo_id"
                                        required>
                                    <option value="">Selecione um veículo...</option>
                                    @foreach($veiculos as $veiculo)
                                        <option value="{{ $veiculo->id }}" {{ old('veiculo_id') == $veiculo->id ? 'selected' : '' }}>
                                            {{ $veiculo->placa }} - {{ $veiculo->marca }} {{ $veiculo->modelo }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('veiculo_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Os dados do veículo e seus compartimentos serão congelados no momento da criação do relatório.
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <a href="{{ route('veiculos.create') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-plus"></i> Cadastrar Novo
                                </a>
                            </div>
                        </div>
                    </fieldset>

                    {{-- Finalidades --}}
                    <fieldset class="mb-4">
                        <legend class="h6 border-bottom pb-2 mb-3">
                            <i class="bi bi-list-check"></i> Finalidades <span class="text-danger">*</span>
                        </legend>

                        @error('finalidades')
                            <div class="alert alert-danger py-2">{{ $message }}</div>
                        @enderror

                        <div id="finalidades-container">
                            @php
                                $oldFinalidades = old('finalidades', [['finalidade' => '', 'descricao_outros' => '']]);
                            @endphp

                            @foreach($oldFinalidades as $index => $oldFin)
                            <div class="row mb-2 finalidade-row">
                                <div class="col-md-4">
                                    <select class="form-select @error("finalidades.{$index}.finalidade") is-invalid @enderror"
                                            name="finalidades[{{ $index }}][finalidade]"
                                            required>
                                        <option value="">Selecione...</option>
                                        @foreach($finalidades as $fin)
                                            <option value="{{ $fin->value }}"
                                                {{ ($oldFin['finalidade'] ?? '') === $fin->value ? 'selected' : '' }}>
                                                {{ $fin->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error("finalidades.{$index}.finalidade")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-5">
                                    <input type="text"
                                           class="form-control @error("finalidades.{$index}.descricao_outros") is-invalid @enderror"
                                           name="finalidades[{{ $index }}][descricao_outros]"
                                           value="{{ $oldFin['descricao_outros'] ?? '' }}"
                                           placeholder="Descrição (se Outros)">
                                    @error("finalidades.{$index}.descricao_outros")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    @if($index > 0)
                                        <button type="button" class="btn btn-outline-danger btn-sm remove-finalidade">
                                            <i class="bi bi-trash"></i> Remover
                                        </button>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-finalidade">
                            <i class="bi bi-plus"></i> Adicionar Finalidade
                        </button>
                    </fieldset>

                    {{-- Observações --}}
                    <fieldset class="mb-4">
                        <legend class="h6 border-bottom pb-2 mb-3">
                            <i class="bi bi-chat-left-text"></i> Observações
                        </legend>

                        <div class="mb-3">
                            <textarea class="form-control @error('observacoes') is-invalid @enderror"
                                      id="observacoes"
                                      name="observacoes"
                                      rows="3"
                                      maxlength="5000">{{ old('observacoes') }}</textarea>
                            @error('observacoes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </fieldset>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Criar Relatório (Rascunho)
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
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('finalidades-container');
    const addBtn = document.getElementById('add-finalidade');
    let index = {{ count($oldFinalidades) }};

    const finalidadeOptions = `
        <option value="">Selecione...</option>
        @foreach($finalidades as $fin)
            <option value="{{ $fin->value }}">{{ $fin->label() }}</option>
        @endforeach
    `;

    addBtn.addEventListener('click', function() {
        const row = document.createElement('div');
        row.className = 'row mb-2 finalidade-row';
        row.innerHTML = `
            <div class="col-md-4">
                <select class="form-select" name="finalidades[${index}][finalidade]" required>
                    ${finalidadeOptions}
                </select>
            </div>
            <div class="col-md-5">
                <input type="text" class="form-control"
                       name="finalidades[${index}][descricao_outros]"
                       placeholder="Descrição (se Outros)">
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-outline-danger btn-sm remove-finalidade">
                    <i class="bi bi-trash"></i> Remover
                </button>
            </div>
        `;
        container.appendChild(row);
        index++;
    });

    container.addEventListener('click', function(e) {
        const btn = e.target.closest('.remove-finalidade');
        if (btn) {
            btn.closest('.finalidade-row').remove();
        }
    });
});
</script>
@endpush
