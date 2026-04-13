@extends('layouts.app')

@section('title', 'Editar Relatório Nº ' . $relatorio->numero_relatorio)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-pencil-square"></i>
        Editar Relatório <strong>#{{ $relatorio->numero_relatorio }}</strong>
    </h2>
    <a href="{{ route('relatorios.show', $relatorio) }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-x-lg"></i> Cancelar
    </a>
</div>

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
                <div class="col-md-3">
                    <label class="form-label">Nº do Relatório</label>
                    <div class="form-control-plaintext fw-bold">{{ $relatorio->numero_relatorio }}</div>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <div class="form-control-plaintext">
                        <span class="badge {{ $relatorio->status->badgeClass() }}">{{ $relatorio->status->label() }}</span>
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
                    <label for="processo" class="form-label">Processo <span class="text-danger">*</span></label>
                    <select class="form-select @error('processo') is-invalid @enderror"
                            id="processo" name="processo" required>
                        @foreach($processos as $proc)
                            <option value="{{ $proc->value }}"
                                {{ old('processo', $relatorio->processo->value) === $proc->value ? 'selected' : '' }}>
                                {{ $proc->label() }}
                            </option>
                        @endforeach
                    </select>
                    @error('processo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
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

                <div class="col-md-4">
                    <label for="lacre_entrada" class="form-label">Lacre Entrada (relatório)</label>
                    <input type="text"
                           class="form-control @error('lacre_entrada') is-invalid @enderror"
                           id="lacre_entrada"
                           name="lacre_entrada"
                           value="{{ old('lacre_entrada', $relatorio->lacre_entrada) }}">
                    @error('lacre_entrada')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="lacre_saida" class="form-label">Lacre Saída (relatório)</label>
                    <input type="text"
                           class="form-control @error('lacre_saida') is-invalid @enderror"
                           id="lacre_saida"
                           name="lacre_saida"
                           value="{{ old('lacre_saida', $relatorio->lacre_saida) }}">
                    @error('lacre_saida')
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
                        <h6 class="mb-0 text-muted"><i class="bi bi-person"></i> Cliente (snapshot — somente leitura)</h6>
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
                        <h6 class="mb-0 text-muted"><i class="bi bi-truck"></i> Veículo (snapshot — somente leitura)</h6>
                    </div>
                    <div class="card-body small">
                        <strong>{{ $relatorio->veiculoSnapshot->placa }}</strong> —
                        {{ $relatorio->veiculoSnapshot->marca }} {{ $relatorio->veiculoSnapshot->modelo }}
                        @if($relatorio->veiculoSnapshot->ano)
                            ({{ $relatorio->veiculoSnapshot->ano }})
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Compartimentos --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h6 class="mb-0"><i class="bi bi-layout-split"></i> Compartimentos do Relatório</h6>
        </div>

        @error('compartimentos')
            <div class="alert alert-danger rounded-0 mb-0 py-2 px-3">{{ $message }}</div>
        @enderror

        @if($relatorio->compartimentos->isEmpty())
            <div class="card-body text-muted">Nenhum compartimento neste relatório.</div>
        @else
            @php $compartimentos = $relatorio->compartimentos->sortBy('numero'); @endphp
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:60px">Nº</th>
                            <th style="width:130px">Capacidade (L) <span class="text-danger">*</span></th>
                            <th>Produto Anterior</th>
                            <th>Lacre Entrada</th>
                            <th>Lacre Saída</th>
                            <th>Observação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($compartimentos as $ci => $comp)
                        @php
                            $old = old("compartimentos.{$ci}");
                        @endphp
                        <tr>
                            {{-- id hidden so controller can identify which row to update --}}
                            <input type="hidden" name="compartimentos[{{ $ci }}][id]" value="{{ $comp->id }}">

                            {{-- numero: editable, validated for duplicates --}}
                            <td>
                                <input type="number"
                                       class="form-control form-control-sm @error("compartimentos.{$ci}.numero") is-invalid @enderror"
                                       name="compartimentos[{{ $ci }}][numero]"
                                       value="{{ old("compartimentos.{$ci}.numero", $comp->numero) }}"
                                       min="1" required style="width:70px">
                                @error("compartimentos.{$ci}.numero")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>

                            <td>
                                <input type="number"
                                       class="form-control form-control-sm @error("compartimentos.{$ci}.capacidade_litros") is-invalid @enderror"
                                       name="compartimentos[{{ $ci }}][capacidade_litros]"
                                       value="{{ old("compartimentos.{$ci}.capacidade_litros", $comp->capacidade_litros) }}"
                                       step="0.01" min="0.01" required style="width:110px">
                                @error("compartimentos.{$ci}.capacidade_litros")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>

                            <td>
                                <input type="text"
                                       class="form-control form-control-sm @error("compartimentos.{$ci}.produto_anterior_nome") is-invalid @enderror"
                                       name="compartimentos[{{ $ci }}][produto_anterior_nome]"
                                       value="{{ old("compartimentos.{$ci}.produto_anterior_nome", $comp->produto_anterior_nome) }}"
                                       maxlength="255">
                                @error("compartimentos.{$ci}.produto_anterior_nome")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>

                            <td>
                                <input type="text"
                                       class="form-control form-control-sm @error("compartimentos.{$ci}.lacre_entrada_numero") is-invalid @enderror"
                                       name="compartimentos[{{ $ci }}][lacre_entrada_numero]"
                                       value="{{ old("compartimentos.{$ci}.lacre_entrada_numero", $comp->lacre_entrada_numero) }}"
                                       maxlength="255">
                                @error("compartimentos.{$ci}.lacre_entrada_numero")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>

                            <td>
                                <input type="text"
                                       class="form-control form-control-sm @error("compartimentos.{$ci}.lacre_saida_numero") is-invalid @enderror"
                                       name="compartimentos[{{ $ci }}][lacre_saida_numero]"
                                       value="{{ old("compartimentos.{$ci}.lacre_saida_numero", $comp->lacre_saida_numero) }}"
                                       maxlength="255">
                                @error("compartimentos.{$ci}.lacre_saida_numero")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>

                            <td>
                                <input type="text"
                                       class="form-control form-control-sm @error("compartimentos.{$ci}.observacao") is-invalid @enderror"
                                       name="compartimentos[{{ $ci }}][observacao]"
                                       value="{{ old("compartimentos.{$ci}.observacao", $comp->observacao) }}"
                                       maxlength="2000">
                                @error("compartimentos.{$ci}.observacao")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
