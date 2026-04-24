@extends('layouts.app')

@section('title', 'Painel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-speedometer2"></i> Painel</h2>
    <a href="{{ route('relatorios.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Novo Relatório
    </a>
</div>

@if(auth()->user()->is_admin)
<div class="card shadow-sm border-warning mb-4">
    <div class="card-header bg-warning bg-opacity-10 d-flex align-items-center gap-2">
        <i class="bi bi-shield-lock text-warning"></i>
        <span class="fw-semibold">Administração — Contagem de OS</span>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success py-2 mb-3">{{ session('success') }}</div>
        @endif
        <form method="POST" action="{{ route('configuracoes.proximo_relatorio') }}" class="row g-3 align-items-end">
            @csrf
            <div class="col-auto">
                <label for="proximo_numero" class="form-label mb-1">
                    Definir próximo nº de relatório
                </label>
                <input type="number"
                       id="proximo_numero"
                       name="proximo_numero"
                       class="form-control @error('proximo_numero') is-invalid @enderror"
                       min="1"
                       value="{{ old('proximo_numero', $proximoRelatorio ?: '') }}"
                       placeholder="Ex: 42"
                       style="width: 160px">
                @error('proximo_numero')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-arrow-repeat"></i> Aplicar
                </button>
            </div>
            @if($proximoRelatorio)
            <div class="col-auto">
                <span class="badge bg-warning text-dark fs-6">
                    Configurado: #{{ $proximoRelatorio }}
                </span>
            </div>
            @endif
        </form>
        <small class="text-muted mt-2 d-block">
            O próximo relatório criado receberá este número. Após ser utilizado, a configuração é removida automaticamente.
        </small>
    </div>
</div>
@endif

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="bi bi-clock-history"></i> Últimos Relatórios</h5>
    </div>
    <div class="card-body p-0">
        @if($relatorios->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1"></i>
                <p class="mt-2">Nenhum relatório encontrado.</p>
                <a href="{{ route('relatorios.create') }}" class="btn btn-outline-primary btn-sm">
                    Criar primeiro relatório
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nº Relatório</th>
                            <th>Status</th>
                            <th>Data do Serviço</th>
                            <th>Veículo</th>
                            <th>Processo</th>
                            <th>Responsável</th>
                            <th>Criado em</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($relatorios as $relatorio)
                        <tr>
                            <td>
                                <a href="{{ route('relatorios.show', $relatorio) }}" class="fw-bold text-decoration-none">
                                    #{{ $relatorio->numero_relatorio }}
                                </a>
                            </td>
                            <td>
                                <span class="badge {{ $relatorio->status->badgeClass() }}">
                                    {{ $relatorio->status->label() }}
                                </span>
                            </td>
                            <td>{{ $relatorio->data_servico->format('d/m/Y') }}</td>
                            <td>
                                @if($relatorio->veiculoSnapshot)
                                    <span class="text-nowrap">
                                        {{ $relatorio->veiculoSnapshot->placa }}
                                        <small class="text-muted">
                                            ({{ $relatorio->veiculoSnapshot->marca }} {{ $relatorio->veiculoSnapshot->modelo }})
                                        </small>
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td style="font-size:12px">Com ventilação forçada</td>
                            <td>{{ $relatorio->responsavelTecnico->name ?? '-' }}</td>
                            <td>{{ $relatorio->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('relatorios.show', $relatorio) }}"
                                   class="btn btn-outline-secondary btn-sm"
                                   title="Ver">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if($relatorio->status === \App\Enums\StatusRelatorio::RASCUNHO || $relatorio->status === \App\Enums\StatusRelatorio::EMITIDO)
                                    <a href="{{ route('relatorios.edit', $relatorio) }}"
                                       class="btn btn-outline-primary btn-sm"
                                       title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
