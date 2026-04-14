@extends('layouts.app')

@section('title', 'Novo Relatório de Descontaminação')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-file-earmark-plus"></i> Novo Relatório de Descontaminação
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('relatorios.store') }}" id="relatorioForm">
                    @csrf

                    {{-- Fixed workflow values (VAPOR / VERIFICACAO_METROLOGICA) --}}
                    {{-- These are not user-selectable in this flow --}}

                    {{-- Dados do Relatório --}}
                    <fieldset class="mb-4">
                        <legend class="h6 border-bottom pb-2 mb-3">
                            <i class="bi bi-file-text"></i> Dados do Relatório
                        </legend>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Nº do Relatório</label>
                                <div class="form-control-plaintext text-muted fst-italic">
                                    <i class="bi bi-hash"></i> Gerado automaticamente ao salvar
                                </div>
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
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <div class="text-muted small">
                                        <i class="bi bi-fire text-warning"></i>
                                        <strong>Processo:</strong> Vapor
                                        <span class="badge bg-secondary ms-1">fixo</span>
                                    </div>
                                    <div class="text-muted small">
                                        <i class="bi bi-list-check text-info"></i>
                                        <strong>Finalidade:</strong> Verificação Metrológica
                                        <span class="badge bg-secondary ms-1">fixo</span>
                                    </div>
                                </div>
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
                                        <option value="{{ $cliente->id }}">
                                            {{ $cliente->nome_razao_social }} ” {{ $cliente->cpf_cnpj }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cliente_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Os dados do cliente serão congelados no momento da criação do Relatório.
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <a href="{{ route('clientes.create') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-plus"></i> Cadastrar Novo Cliente
                                </a>
                            </div>
                        </div>
                    </fieldset>

                    {{-- Veículo (dependent on Cliente) --}}
                    <fieldset class="mb-4">
                        <legend class="h6 border-bottom pb-2 mb-3">
                            <i class="bi bi-truck"></i> Veículo
                        </legend>

                        @error('veiculo_id')
                            <div class="alert alert-danger py-2 mb-2">{{ $message }}</div>
                        @enderror

                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="veiculo_id" class="form-label">Selecionar Veículo <span class="text-danger">*</span></label>
                                <select class="form-select"
                                        id="veiculo_id"
                                        name="veiculo_id"
                                        required
                                        disabled>
                                    <option value="">” Selecione um cliente primeiro ”</option>
                                </select>
                                <div class="form-text" id="veiculo-hint">
                                    Selecione um cliente para ver os Veículos disponíveis.
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <a id="add-veiculo-btn"
                                   href="{{ route('veiculos.create') }}"
                                   class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-plus"></i> Novo Veículo
                                </a>
                            </div>
                        </div>
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
                        <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                            <i class="bi bi-check-lg"></i>Imprimir Relatório
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
    const clienteSelect  = document.getElementById('cliente_id');
    const veiculoSelect  = document.getElementById('veiculo_id');
    const addVeiculoBtn  = document.getElementById('add-veiculo-btn');
    const veiculoHint    = document.getElementById('veiculo-hint');
    const submitBtn      = document.getElementById('submitBtn');

    const baseVeiculoUrl = '{{ route("veiculos.create") }}';

    // Read URL params for pre-selection (e.g. returning from vehicle creation)
    const urlParams      = new URLSearchParams(window.location.search);
    const initClienteId  = urlParams.get('cliente_id')   || '{{ old("cliente_id") }}';
    const initVeiculoId  = urlParams.get('new_veiculo_id') || '{{ old("veiculo_id") }}';

    function updateSubmitState() {
        const hasCliente = clienteSelect.value !== '';
        const hasVeiculo = veiculoSelect.value !== '';
        submitBtn.disabled = !(hasCliente && hasVeiculo);
    }

    function loadVeiculos(clienteId, preSelectId) {
        if (!clienteId) {
            veiculoSelect.innerHTML = '<option value="">Selecione um cliente primeiro ”</option>';
            veiculoSelect.disabled  = true;
            addVeiculoBtn.href      = baseVeiculoUrl;
            veiculoHint.textContent = 'Selecione um cliente para ver os Veículos disponíveis.';
            updateSubmitState();
            return;
        }

        veiculoSelect.innerHTML = '<option value="">Carregando...</option>';
        veiculoSelect.disabled  = true;

        const newVeiculoUrl = `${baseVeiculoUrl}?cliente_id=${clienteId}&return_to=relatorios_create&return_cliente_id=${clienteId}`;
        addVeiculoBtn.href  = newVeiculoUrl;

        fetch(`/api/clientes/${clienteId}/veiculos`)
            .then(function (r) { return r.json(); })
            .then(function (veiculos) {
                if (veiculos.length === 0) {
                    veiculoSelect.innerHTML = '<option value="">Nenhum Veículo cadastrado para este cliente</option>';
                    veiculoHint.textContent  = 'Clique em "+ Novo Veículo" para cadastrar um Veículo para este cliente.';
                } else {
                    veiculoSelect.innerHTML  = '<option value="">Selecione um Veículo...</option>';
                    veiculos.forEach(function (v) {
                        const opt     = document.createElement('option');
                        opt.value     = v.id;
                        opt.textContent = v.text + ' (' + v.numero_compartimentos + ' compart.)';
                        if (preSelectId && String(v.id) === String(preSelectId)) {
                            opt.selected = true;
                        }
                        veiculoSelect.appendChild(opt);
                    });
                    veiculoHint.textContent = 'Os dados do Veículo serão congelados no Relatório.';
                }
                veiculoSelect.disabled = false;
                updateSubmitState();
            })
            .catch(function () {
                veiculoSelect.innerHTML = '<option value="">Erro ao carregar Veículos</option>';
                veiculoSelect.disabled  = true;
            });
    }

    clienteSelect.addEventListener('change', function () {
        loadVeiculos(this.value, null);
    });

    veiculoSelect.addEventListener('change', updateSubmitState);

    // Auto-initialize from URL params (e.g. after creating a new vehicle)
    if (initClienteId) {
        clienteSelect.value = initClienteId;
        loadVeiculos(initClienteId, initVeiculoId);
    }
});
</script>
