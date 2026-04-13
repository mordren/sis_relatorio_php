@extends('layouts.app')

@section('title', 'Relatório Nº ' . $relatorio->numero_relatorio)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-file-earmark-text"></i>
        Relatório <strong>#{{ $relatorio->numero_relatorio }}</strong>
    </h2>
    <div class="d-flex gap-2">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Painel
        </a>
        @if($relatorio->status === \App\Enums\StatusRelatorio::RASCUNHO)
            <a href="{{ route('relatorios.edit', $relatorio) }}" class="btn btn-primary btn-sm">
                <i class="bi bi-pencil"></i> Editar
            </a>
        @endif
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Report header --}}
<div class="row g-3 mb-4">
    <div class="col-md-8">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="bi bi-info-circle"></i> Dados do Relatório</h6>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Nº do Relatório</dt>
                    <dd class="col-sm-8"><strong>{{ $relatorio->numero_relatorio }}</strong></dd>

                    <dt class="col-sm-4">Status</dt>
                    <dd class="col-sm-8">
                        <span class="badge {{ $relatorio->status->badgeClass() }}">
                            {{ $relatorio->status->label() }}
                        </span>
                    </dd>

                    <dt class="col-sm-4">Data do Serviço</dt>
                    <dd class="col-sm-8">{{ $relatorio->data_servico->format('d/m/Y') }}</dd>

                    <dt class="col-sm-4">Processo</dt>
                    <dd class="col-sm-8">{{ $relatorio->processo->label() }}</dd>

                    <dt class="col-sm-4">Responsável</dt>
                    <dd class="col-sm-8">{{ $relatorio->responsavelTecnico->name ?? '-' }}</dd>

                    @if($relatorio->lacre_entrada)
                        <dt class="col-sm-4">Lacre Entrada</dt>
                        <dd class="col-sm-8">{{ $relatorio->lacre_entrada }}</dd>
                    @endif

                    @if($relatorio->lacre_saida)
                        <dt class="col-sm-4">Lacre Saída</dt>
                        <dd class="col-sm-8">{{ $relatorio->lacre_saida }}</dd>
                    @endif

                    @if($relatorio->observacoes)
                        <dt class="col-sm-4">Observações</dt>
                        <dd class="col-sm-8">{{ $relatorio->observacoes }}</dd>
                    @endif

                    <dt class="col-sm-4">Finalidades</dt>
                    <dd class="col-sm-8">
                        @foreach($relatorio->finalidades as $fim)
                            <span class="badge bg-info text-dark me-1">
                                {{ $fim->finalidade->label() }}
                                @if($fim->descricao_outros) — {{ $fim->descricao_outros }} @endif
                            </span>
                        @endforeach
                    </dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="bi bi-person"></i> Cliente (snapshot)</h6>
            </div>
            <div class="card-body">
                @if($relatorio->clienteSnapshot)
                    @php $c = $relatorio->clienteSnapshot; @endphp
                    <dl class="row mb-0 small">
                        <dt class="col-sm-5">Nome/Razão</dt>
                        <dd class="col-sm-7">{{ $c->nome_razao_social }}</dd>

                        <dt class="col-sm-5">CPF/CNPJ</dt>
                        <dd class="col-sm-7">{{ $c->cpf_cnpj }}</dd>

                        @if($c->cidade)
                            <dt class="col-sm-5">Cidade/UF</dt>
                            <dd class="col-sm-7">{{ $c->cidade }}/{{ $c->estado }}</dd>
                        @endif

                        @if($c->telefone)
                            <dt class="col-sm-5">Telefone</dt>
                            <dd class="col-sm-7">{{ $c->telefone }}</dd>
                        @endif
                    </dl>
                @else
                    <p class="text-muted small mb-0">Snapshot não disponível.</p>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Vehicle snapshot --}}
@if($relatorio->veiculoSnapshot)
    @php $v = $relatorio->veiculoSnapshot; @endphp
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h6 class="mb-0"><i class="bi bi-truck"></i> Veículo (snapshot)</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-2"><strong>Placa</strong><br>{{ $v->placa }}</div>
                <div class="col-sm-3"><strong>Marca / Modelo</strong><br>{{ $v->marca }} {{ $v->modelo }}</div>
                <div class="col-sm-2"><strong>Ano</strong><br>{{ $v->ano ?? '-' }}</div>
                <div class="col-sm-5"><strong>Tipo</strong><br>{{ $v->tipo_veiculo ?? '-' }}</div>
            </div>
        </div>
    </div>
@endif

{{-- Compartimentos snapshot --}}
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white">
        <h6 class="mb-0"><i class="bi bi-layout-split"></i> Compartimentos (snapshot)</h6>
    </div>
    @if($relatorio->compartimentos->isEmpty())
        <div class="card-body text-muted">Nenhum compartimento registrado.</div>
    @else
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nº</th>
                        <th>Capacidade (L)</th>
                        <th>Produto Anterior</th>
                        <th>Lacre Entrada</th>
                        <th>Lacre Saída</th>
                        <th>Observação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($relatorio->compartimentos->sortBy('numero') as $comp)
                    <tr>
                        <td>{{ $comp->numero }}</td>
                        <td>{{ number_format($comp->capacidade_litros, 2, ',', '.') }}</td>
                        <td>{{ $comp->produto_anterior_nome ?? '-' }}</td>
                        <td>{{ $comp->lacre_entrada_numero ?? '-' }}</td>
                        <td>{{ $comp->lacre_saida_numero ?? '-' }}</td>
                        <td>{{ $comp->observacao ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
