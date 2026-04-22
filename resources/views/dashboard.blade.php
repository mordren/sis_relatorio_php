@extends('layouts.app')

@section('title', 'Painel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-speedometer2"></i> Painel</h2>
    <a href="{{ route('relatorios.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Novo Relatório
    </a>
</div>

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
                                @if($relatorio->status === \App\Enums\StatusRelatorio::RASCUNHO)
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
