@extends('layouts.app')

@section('title', 'Editar Relatório Nº ' . $relatorio->numero_relatorio)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-pencil-square"></i>
        Editar Relatório <strong>#{{ $relatorio->numero_relatorio }}</strong>
    </h2>
    <div class="d-flex gap-2">
        <form method="POST" action="{{ route('relatorios.refresh-snapshots', $relatorio) }}"
              onsubmit="return confirm('Atualizar os dados de cliente e veículo neste relatório com os dados atuais cadastrados? Esta ação não pode ser desfeita.')">
            @csrf
            <button type="submit" class="btn btn-outline-warning btn-sm">
                <i class="bi bi-arrow-clockwise"></i> Atualizar cliente/veículo
            </button>
        </form>
        <a href="{{ route('relatorios.show', $relatorio) }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-x-lg"></i> Cancelar
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form method="POST" action="{{ route('relatorios.update', $relatorio) }}" id="editForm">
    @csrf
    @method('PUT')

    {{-- Report-level data --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h6 class="mb-0"><i class="bi bi-file-text"></i> Dados do Relatório</h6>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-2">
                    <label class="form-label">Nº Relatório</label>
                    <div class="form-control-plaintext fw-bold">{{ $relatorio->numero_relatorio }}</div>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <div class="form-control-plaintext">
                        <span class="badge {{ $relatorio->status->badgeClass() }}">{{ $relatorio->status->label() }}</span>
                    </div>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Processo</label>
                    <div class="form-control-plaintext text-muted">
                        {{ $relatorio->processo->label() }}
                        <span class="badge bg-secondary ms-1">fixo</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="data_servico" class="form-label">Data do Serviço <span class="text-danger">*</span></label>
                    <input type="date"
                           class="form-control @error('data_servico') is-invalid @enderror"
                           id="data_servico"
                           name="data_servico"
                           value="{{ old('data_servico', $relatorio->data_servico->format('Y-m-d')) }}"
                           required>
                    @error('data_servico')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="responsavel_tecnico_id" class="form-label">Responsável Técnico <span class="text-danger">*</span></label>
                    <select class="form-select @error('responsavel_tecnico_id') is-invalid @enderror"
                            id="responsavel_tecnico_id" name="responsavel_tecnico_id" required>
                        @foreach($responsaveis as $resp)
                            <option value="{{ $resp->id }}"
                                {{ old('responsavel_tecnico_id', $relatorio->responsavel_tecnico_id) == $resp->id ? 'selected' : '' }}>
                                {{ $resp->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('responsavel_tecnico_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-0">
                <label for="observacoes" class="form-label">Observações</label>
                <textarea class="form-control @error('observacoes') is-invalid @enderror"
                          id="observacoes" name="observacoes" rows="3"
                          maxlength="5000">{{ old('observacoes', $relatorio->observacoes) }}</textarea>
                @error('observacoes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    {{-- Snapshot info: client & vehicle (read-only) --}}
    <div class="row g-3 mb-4">
        @if($relatorio->clienteSnapshot)
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h6 class="mb-0 text-muted"><i class="bi bi-person"></i> Cliente (snapshot)</h6>
                    </div>
                    <div class="card-body small">
                        <strong>{{ $relatorio->clienteSnapshot->nome_razao_social }}</strong><br>
                        {{ $relatorio->clienteSnapshot->cpf_cnpj }}
                        @if($relatorio->clienteSnapshot->cidade)
                            <br>{{ $relatorio->clienteSnapshot->cidade }}/{{ $relatorio->clienteSnapshot->estado }}
                        @endif
                    </div>
                </div>
            </div>
        @endif

        @if($relatorio->veiculoSnapshot)
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h6 class="mb-0 text-muted"><i class="bi bi-truck"></i> Veículo (snapshot)</h6>
                    </div>
                    <div class="card-body small">
                        <strong>{{ $relatorio->veiculoSnapshot->placa }}</strong> ”
                        {{ $relatorio->veiculoSnapshot->marca }} {{ $relatorio->veiculoSnapshot->modelo }}
                        @if($relatorio->veiculoSnapshot->ano)
                            ({{ $relatorio->veiculoSnapshot->ano }})
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white d-flex align-items-center justify-content-between">
            <h6 class="mb-0"><i class="bi bi-layout-split"></i> Compartimentos do Relatório</h6>
            <small class="text-muted">{{ $relatorio->compartimentos->count() }} compartimento(s)</small>
        </div>

        @error('compartimentos')
            <div class="alert alert-danger rounded-0 mb-0 py-2 px-3">{{ $message }}</div>
        @enderror

        @if($relatorio->compartimentos->isEmpty())
            <div class="card-body text-muted">Nenhum compartimento neste relatório.</div>
        @else
            @php $compartimentos = $relatorio->compartimentos->sortBy('numero'); @endphp
            <div class="card-body p-0">
                <div class="accordion accordion-flush" id="accordionCompartimentos">
                @foreach($compartimentos as $ci => $comp)
                    <div class="accordion-item" data-comp-idx="{{ $ci }}">
                        <h2 class="accordion-header">
                            <button class="accordion-button {{ $ci > 0 ? 'collapsed' : '' }}"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#comp-{{ $ci }}"
                                    aria-expanded="{{ $ci === 0 ? 'true' : 'false' }}">
                                <i class="bi bi-circle me-2"></i>
                                Compartimento <strong class="ms-1">#{{ $comp->numero }}</strong>
                                @if($comp->produto_anterior_nome)
                                    <span class="ms-2 text-muted small fw-normal">” {{ $comp->produto_anterior_nome }}</span>
                                @endif
                            </button>
                        </h2>
                        <div id="comp-{{ $ci }}"
                             class="accordion-collapse collapse {{ $ci === 0 ? 'show' : '' }}"
                             data-bs-parent="#accordionCompartimentos">
                            <div class="accordion-body">
                                {{-- Hidden fields --}}
                                <input type="hidden" name="compartimentos[{{ $ci }}][id]" value="{{ $comp->id }}">
                                <input type="hidden" name="compartimentos[{{ $ci }}][numero]" value="{{ $comp->numero }}">

                                {{-- Row 1: User inputs ” Volume + Product --}}
                                <div class="row g-2 mb-3">
                                    <div class="col-sm-2">
                                        <label class="form-label form-label-sm">Compart. Nº</label>
                                        <div class="form-control-plaintext form-control-sm fw-bold ps-2">
                                            {{ $comp->numero }}
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label form-label-sm">
                                            Volume / Capacidade (L) m³ <i class="bi bi-calculator text-info" title="Usado no cálculo de Tempo e Volume de Ar"></i>
                                        </label>
                                        <input type="number"
                                               class="form-control form-control-sm @error("compartimentos.{$ci}.capacidade_litros") is-invalid @enderror"
                                               name="compartimentos[{{ $ci }}][capacidade_litros]"
                                               value="{{ old("compartimentos.{$ci}.capacidade_litros", $comp->capacidade_litros) }}"
                                               data-field="capacidade_litros"
                                               step="0.01" min="0.01"
                                               placeholder="Ex: 30 = 30.000 litros">
                                        @error("compartimentos.{$ci}.capacidade_litros")
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label form-label-sm">
                                            Combustível / Produto <i class="bi bi-arrow-right text-info" title="Preenche automaticamente o Nº ONU"></i>
                                        </label>
                                        <select class="form-select form-select-sm @error("compartimentos.{$ci}.produto_anterior_nome") is-invalid @enderror"
                                                name="compartimentos[{{ $ci }}][produto_anterior_nome]"
                                                data-field="produto_anterior_nome">
                                            
                                            @foreach($produtos as $produto)
                                                <option value="{{ $produto->nome }}"
                                                        data-onu="{{ $produto->numero_onu }}"
                                                        {{ old("compartimentos.{$ci}.produto_anterior_nome", $comp->produto_anterior_nome) === $produto->nome ? 'selected' : '' }}>
                                                    {{ $produto->nome }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error("compartimentos.{$ci}.produto_anterior_nome")
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Row 2: Computed/auto-filled values (read-only display) --}}
                                <div class="row g-2 mb-2">
                                    <div class="col-sm-2">
                                        <label class="form-label form-label-sm text-muted">Nº ONU</label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-light border-secondary-subtle" data-display="numero_onu">
                                                {{ $comp->numero_onu ?? '”' }}
                                            </span>
                                        </div>
                                        <div class="form-text">auto</div>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="form-label form-label-sm text-muted">Tempo (min)</label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-light border-secondary-subtle" style="min-width:60px" data-display="tempo_minutos">
                                                {{ $comp->tempo_minutos ?? '”' }}
                                            </span>
                                        </div>
                                        <div class="form-text">calculado</div>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="form-label form-label-sm text-muted">Volume de Ar</label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-light border-secondary-subtle" style="min-width:60px" data-display="volume_ar">
                                                {{ $comp->volume_ar ?? '”' }}
                                            </span>
                                        </div>
                                        <div class="form-text">calculado</div>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="form-label form-label-sm text-muted">Classe Risco</label>
                                        <span class="badge bg-warning text-dark fs-6 d-block mt-1">3</span>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="form-label form-label-sm text-muted">Pressão Vapor</label>
                                        <span class="badge bg-secondary fs-6 d-block mt-1">NA</span>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="form-label form-label-sm text-muted">Neutralizante</label>
                                        <span class="badge bg-secondary fs-6 d-block mt-1">NA</span>
                                    </div>
                                </div>

                                {{-- Row 3: Observations --}}
                                <div class="row g-2">
                                    <div class="col-sm-12">
                                        <label class="form-label form-label-sm">Observação</label>
                                        <input type="text"
                                               class="form-control form-control-sm @error("compartimentos.{$ci}.observacao") is-invalid @enderror"
                                               name="compartimentos[{{ $ci }}][observacao]"
                                               value="{{ old("compartimentos.{$ci}.observacao", $comp->observacao) }}"
                                               maxlength="2000">
                                        @error("compartimentos.{$ci}.observacao")
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        @endif
    </div>

    <div class="d-flex justify-content-between">
        <a href="{{ route('relatorios.show', $relatorio) }}" class="btn btn-outline-secondary">
            <i class="bi bi-x-lg"></i> Cancelar
        </a>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-lg"></i> Salvar Alterações
        </button>
    </div>
</form>

@endsection

@push('scripts')
<script>
/**
 * SRD-compatible compartment auto-fill logic.
 *
 * Business rules applied on the client side (also enforced server-side):
 *   - tempo_minutos  = 60 (fixo)
 *   - volume_ar      = capacidade_litros * 20
 *   - numero_onu     = derived from selected product (data-onu attribute)
 *   - classe_risco   = always 3  (static badge)
 *   - pressao_vapor  = always NA (static badge)
 *   - neutralizante  = always NA (static badge)
 */
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('[data-comp-idx]').forEach(function (item) {
        const volumeInput   = item.querySelector('[data-field="capacidade_litros"]');
        const produtoSelect = item.querySelector('[data-field="produto_anterior_nome"]');
        const onuDisplay    = item.querySelector('[data-display="numero_onu"]');
        const tempoDisplay  = item.querySelector('[data-display="tempo_minutos"]');
        const volArDisplay  = item.querySelector('[data-display="volume_ar"]');

        function recalcFromVolume() {
            const vol = parseFloat(volumeInput ? volumeInput.value : '');
            if (!isNaN(vol) && vol > 0) {
                if (tempoDisplay) tempoDisplay.textContent = 60;
                if (volArDisplay) volArDisplay.textContent = (vol * 20);
            } else {
                if (tempoDisplay) tempoDisplay.textContent = '”';
                if (volArDisplay) volArDisplay.textContent = '”';
            }
        }

        function fillFromProduct() {
            if (!produtoSelect) return;
            const selectedOption = produtoSelect.options[produtoSelect.selectedIndex];
            const onu = selectedOption ? (selectedOption.getAttribute('data-onu') || '') : '';
            if (onuDisplay) onuDisplay.textContent = onu || '”';
        }

        if (volumeInput) {
            volumeInput.addEventListener('blur', recalcFromVolume);
            volumeInput.addEventListener('input', recalcFromVolume);
        }

        if (produtoSelect) {
            produtoSelect.addEventListener('change', fillFromProduct);
            // Run on load to reflect current values
            fillFromProduct();
        }

        // Recalc on load if volume is already populated
        if (volumeInput && volumeInput.value) {
            recalcFromVolume();
        }
    });
});
</script>
@endpush
