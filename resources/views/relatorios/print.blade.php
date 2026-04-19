@php
    $v    = $relatorio->veiculoSnapshot;
    $c    = $relatorio->clienteSnapshot;
    $resp = $relatorio->responsavelTecnico;
    $compartimentos = $relatorio->compartimentos->sortBy('numero');
    $equipamentos   = $relatorio->equipamentosUtilizados;
@endphp
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Descontaminação Nº {{ $relatorio->numero_relatorio }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ================================================
           ROOT / RESET
           ================================================ */
        :root {
            --c-border: #222;
            --c-header: #0f3b5e;
            --c-header-text: #fff;
            --c-light: #e9eef4;
            --c-muted: #666;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', Arial, Helvetica, sans-serif;
            font-size: 10px;
            line-height: 1.35;
            color: #000;
            background: #d5dbe3;
            padding: 16px;
        }

        /* ================================================
           PAGE CONTAINER (screen)
           ================================================ */
        .page {
            width: 210mm;
            min-height: 290mm;
            margin: 0 auto 24px;
            background: #fff;
            padding: 10mm 12mm;
            box-shadow: 0 2px 16px rgba(0,0,0,.12);
            position: relative;
        }

        /* ================================================
           COMMON HEADER (reused on all 3 pages)
           ================================================ */
        .hdr {
            display: flex;
            border: 2px solid var(--c-border);
            margin-bottom: 6px;
        }
        .hdr-logo {
            width: 80px;
            border-right: 2px solid var(--c-border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 9px;
            color: var(--c-header);
            text-align: center;
            padding: 6px;
        }
        .hdr-center {
            flex: 1;
            text-align: center;
            padding: 6px 8px;
        }
        .hdr-center h1 { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 1px; }
        .hdr-center .subtitle { font-size: 8px; color: var(--c-muted); }
        .hdr-right {
            width: 150px;
            border-left: 2px solid var(--c-border);
            font-size: 8px;
            padding: 4px 8px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .hdr-right .doc-id { font-weight: 700; font-size: 10px; color: var(--c-header); }

        /* ================================================
           SECTION BOX
           ================================================ */
        .sec {
            border: 1.5px solid var(--c-border);
            margin-bottom: 5px;
        }
        .sec-title {
            background: var(--c-header);
            color: var(--c-header-text);
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 2px 6px;
            letter-spacing: .4px;
        }
        .sec-body {
            padding: 4px 6px;
        }

        /* ================================================
           FIELD ROWS
           ================================================ */
        .fr {
            display: flex;
            flex-wrap: wrap;
            border-bottom: 1px solid #ddd;
            padding: 1.5px 0;
            gap: 0 4px;
        }
        .fr:last-child { border-bottom: none; }
        .fl { font-weight: 600; font-size: 9px; color: #333; min-width: 120px; }
        .fv { flex: 1; font-size: 10px; }

        /* ================================================
           CHECKBOX ITEMS
           ================================================ */
        .cg { display: flex; flex-wrap: wrap; gap: 2px 14px; }
        .ci { display: inline-flex; align-items: center; gap: 3px; font-size: 9px; }
        .cb {
            width: 11px; height: 11px;
            border: 1.5px solid #333;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 8px; font-weight: 700; line-height: 1;
        }
        .cb.on { background: var(--c-header); color: #fff; }

        /* ================================================
           INSPECTION
           ================================================ */
        .insp { display: flex; gap: 8px; align-items: flex-start; width: 100%; }
        .insp-lbl { font-weight: 600; font-size: 9px; min-width: 110px; }
        .yn { display: inline-flex; align-items: center; gap: 2px; font-size: 9px; margin-right: 8px; }
        .insp-desc { flex: 1; border-bottom: 1px dotted #999; min-height: 12px; font-size: 9px; }

        /* ================================================
           TABLES
           ================================================ */
        .tbl {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }
        .tbl th, .tbl td {
            border: 1px solid var(--c-border);
            padding: 2px 4px;
            text-align: center;
            vertical-align: middle;
        }
        .tbl th {
            background: var(--c-light);
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
        }

        /* ================================================
           SIGNATURES
           ================================================ */
        .sigs { display: flex; justify-content: space-around; gap: 16px; margin-top: 18px; }
        .sig { text-align: center; flex: 1; }
        .sig-line { border-top: 1px solid #000; margin: 0 12px; padding-top: 2px; font-size: 9px; }

        /* ================================================
           PAGE FOOTER (inside each page)
           ================================================ */
        .pg-foot {
            position: absolute;
            bottom: 10mm;
            left: 12mm;
            right: 12mm;
            text-align: center;
            font-size: 7px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 3px;
        }

        /* ================================================
           SCREEN-ONLY TOOLBAR
           ================================================ */
        .toolbar {
            max-width: 210mm;
            margin: 0 auto 12px;
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }
        .toolbar a, .toolbar button {
            font-family: inherit;
            font-size: 12px;
            padding: 6px 16px;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
            border: none;
        }
        .toolbar .btn-back { background: #6c757d; color: #fff; }
        .toolbar .btn-print { background: #198754; color: #fff; }

        /* ================================================
           NOTES / SMALL TEXT
           ================================================ */
        .note-block { font-size: 8px; color: #333; text-align: justify; margin-top: 4px; }

        /* ================================================
           PRINT OVERRIDES
           ================================================ */
        @page { size: A4 portrait; margin: 8mm; }

        @media print {
            body { background: #fff; padding: 0; margin: 0; }
            .page {
                box-shadow: none;
                margin: 0;
                padding: 6mm 10mm;
                width: 100%;
                min-height: auto;
                page-break-after: always;
            }
            .page:last-child { page-break-after: auto; }
            .toolbar { display: none !important; }
            .pg-foot { position: relative; bottom: auto; left: auto; right: auto; margin-top: 10px; }
        }
    </style>
</head>
<body>

{{-- ═══════════════════════════════════════════════════════════════
     TOOLBAR (screen only)
     ═══════════════════════════════════════════════════════════════ --}}
<div class="toolbar">
    <a href="{{ route('relatorios.show', $relatorio) }}" class="btn-back">&larr; Voltar</a>
    <button type="button" onclick="window.print()" class="btn-print">🖨 Imprimir / Salvar PDF</button>
</div>


{{-- ╔═══════════════════════════════════════════════════════════════╗
     ║  PAGE 1 — FOR TEC 01 — Verificação Inicial                  ║
     ╚═══════════════════════════════════════════════════════════════╝ --}}
<div class="page" id="for-tec-01">

    {{-- Header --}}
    <div class="hdr">
        <div class="hdr-logo">LOGO<br><small>Empresa</small></div>
        <div class="hdr-center">
            <h1>Verificação Inicial do Veículo</h1>
            <div class="subtitle">Serviço de Descontaminação — FOR TEC 01</div>
        </div>
        <div class="hdr-right">
            Nº Relatório<br>
            <span class="doc-id">{{ $relatorio->numero_relatorio }}</span><br>
            <small>{{ $relatorio->data_servico->format('d/m/Y') }}</small>
        </div>
    </div>

    {{-- Identification --}}
    <div class="sec">
        <div class="sec-title">Identificação</div>
        <div class="sec-body">
            <div class="fr">
                <span class="fl">Nome do Condutor:</span>
                <span class="fv">{{ $resp?->name ?? '—' }}</span>
            </div>
            <div class="fr">
                <span class="fl">Nº do Equipamento:</span>
                <span class="fv">
                    @if($equipamentos->isNotEmpty())
                        {{ $equipamentos->pluck('nome_snapshot')->join(', ') }}
                    @else — @endif
                </span>
            </div>
            <div class="fr">
                <span class="fl">Veículo:</span>
                <span class="fv">{{ $v?->marca }} {{ $v?->modelo }} {{ $v?->ano ? '('.$v->ano.')' : '' }}</span>
                <span class="fl" style="min-width:50px">Placa:</span>
                <span class="fv" style="flex:0 0 120px;font-weight:600">{{ strtoupper($v?->placa ?? '—') }}</span>
            </div>
            <div class="fr">
                <span class="fl">Tipo do Veículo:</span>
                <span class="fv">{{ $v?->tipo_veiculo ?? '—' }}</span>
            </div>
        </div>
    </div>

    {{-- Decontamination processes --}}
    <div class="sec">
        <div class="sec-title">Processos de Descontaminação</div>
        <div class="sec-body">
            <div class="cg">
                @foreach(\App\Enums\ProcessoRelatorio::cases() as $proc)
                    <span class="ci">
                        <span class="cb {{ $relatorio->processo === $proc ? 'on' : '' }}">{{ $relatorio->processo === $proc ? '✓' : '' }}</span>
                        {{ $proc->label() }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Vehicle inspection --}}
    <div class="sec">
        <div class="sec-title">Verificação do Veículo</div>
        <div class="sec-body">
            <div class="fr">
                <div class="insp">
                    <span class="insp-lbl">Avarias Externas:</span>
                    <span class="yn"><span class="cb {{ $relatorio->observacoes ? 'on' : '' }}">{{ $relatorio->observacoes ? '✓' : '' }}</span> Sim</span>
                    <span class="yn"><span class="cb {{ !$relatorio->observacoes ? 'on' : '' }}">{{ !$relatorio->observacoes ? '✓' : '' }}</span> Não</span>
                    <span class="insp-desc">{{ $relatorio->observacoes ?? '' }}</span>
                </div>
            </div>
            <div class="fr">
                <div class="insp">
                    <span class="insp-lbl">Avarias Internas:</span>
                    <span class="yn"><span class="cb"></span> Sim</span>
                    <span class="yn"><span class="cb on">✓</span> Não</span>
                    <span class="insp-desc"></span>
                </div>
            </div>
        </div>
    </div>

    {{-- Seals --}}
    @if($relatorio->lacre_entrada || $relatorio->lacre_saida)
    <div class="sec">
        <div class="sec-title">Lacres</div>
        <div class="sec-body">
            <div class="fr">
                <span class="fl">Lacre Entrada:</span>
                <span class="fv">{{ $relatorio->lacre_entrada ?? '—' }}</span>
                <span class="fl" style="min-width:90px">Lacre Saída:</span>
                <span class="fv">{{ $relatorio->lacre_saida ?? '—' }}</span>
            </div>
        </div>
    </div>
    @endif

    {{-- Declaration + signatures --}}
    <div class="sec" style="margin-top:12px">
        <div class="sec-title">Declaração de Entrega</div>
        <div class="sec-body">
            <p class="note-block">
                Declaro que entreguei o veículo acima identificado para a realização do serviço de descontaminação,
                estando ciente das condições de recebimento e dos procedimentos a serem realizados.
            </p>
            <div class="fr" style="margin-top:4px">
                <span class="fl">Local e Data:</span>
                <span class="fv">__________________, {{ $relatorio->data_servico->format('d/m/Y') }}</span>
            </div>
        </div>
    </div>

    <div class="sigs">
        <div class="sig">
            <div style="height:40px"></div>
            <div class="sig-line">Condutor / Responsável pela Entrega</div>
        </div>
        <div class="sig">
            <div style="height:40px"></div>
            <div class="sig-line">Representante da Empresa</div>
        </div>
    </div>

    <div class="pg-foot">FOR TEC 01 — Verificação Inicial · Relatório {{ $relatorio->numero_relatorio }} · Página 1 de 3</div>
</div>


{{-- ╔═══════════════════════════════════════════════════════════════╗
     ║  PAGE 2 — FOR TEC 02 — Lista de Verificação / OS            ║
     ╚═══════════════════════════════════════════════════════════════╝ --}}
<div class="page" id="for-tec-02">

    {{-- Header --}}
    <div class="hdr">
        <div class="hdr-logo">LOGO<br><small>Empresa</small></div>
        <div class="hdr-center">
            <h1>Lista de Verificação</h1>
            <div class="subtitle">Ordem de Serviço — FOR TEC 02</div>
        </div>
        <div class="hdr-right">
            Nº Controle OS<br>
            <span class="doc-id">{{ $relatorio->numero_relatorio }}</span><br>
            <small>{{ $relatorio->data_servico->format('d/m/Y') }}</small>
        </div>
    </div>

    {{-- Service data --}}
    <div class="sec">
        <div class="sec-title">Dados do Serviço</div>
        <div class="sec-body">
            <div class="fr">
                <span class="fl">Placa:</span>
                <span class="fv" style="font-weight:600">{{ strtoupper($v?->placa ?? '—') }}</span>
                <span class="fl" style="min-width:100px">Nº Equipamento:</span>
                <span class="fv">
                    @if($equipamentos->isNotEmpty())
                        {{ $equipamentos->pluck('nome_snapshot')->join(', ') }}
                    @else — @endif
                </span>
            </div>
            <div class="fr">
                <span class="fl">Data Início:</span>
                <span class="fv">{{ $relatorio->data_servico->format('d/m/Y') }}</span>
                <span class="fl" style="min-width:100px">Data Fim:</span>
                <span class="fv">{{ $relatorio->emitido_em ? $relatorio->emitido_em->format('d/m/Y') : '—' }}</span>
            </div>
            <div class="fr">
                <span class="fl">Procedimento:</span>
                <span class="fv">PT-01</span>
                <span class="fl" style="min-width:100px">Norma:</span>
                <span class="fv">Portaria 455/2021</span>
            </div>
        </div>
    </div>

    {{-- Finalidade checkboxes --}}
    <div class="sec">
        <div class="sec-title">Finalidade</div>
        <div class="sec-body">
            <div class="cg">
                @php $relFinalidades = $relatorio->finalidades->pluck('finalidade')->map(fn($f) => $f->value)->all(); @endphp
                @foreach(\App\Enums\FinalidadeRelatorio::cases() as $fin)
                    <span class="ci">
                        <span class="cb {{ in_array($fin->value, $relFinalidades) ? 'on' : '' }}">{{ in_array($fin->value, $relFinalidades) ? '✓' : '' }}</span>
                        {{ $fin->label() }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Compartments table --}}
    <div class="sec">
        <div class="sec-title">Compartimentos</div>
        <div class="sec-body" style="padding:0">
            <table class="tbl">
                <thead>
                    <tr>
                        <th style="width:24px">Nº</th>
                        <th>Volume (L)</th>
                        <th>Produto Anterior</th>
                        <th>Nº ONU</th>
                        <th>Classe Risco</th>
                        <th>CO</th>
                        <th>O₂</th>
                        <th>LEL</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($compartimentos as $comp)
                    <tr>
                        <td><strong>{{ $comp->numero }}</strong></td>
                        <td>{{ $comp->capacidade_litros !== null ? number_format((float)$comp->capacidade_litros, 2, ',', '.') : '—' }}</td>
                        <td style="text-align:left;padding-left:6px">{{ $comp->produto_anterior_nome ?? '—' }}</td>
                        <td>{{ $comp->numero_onu ?? '—' }}</td>
                        <td>{{ $comp->classe_risco ?? '—' }}</td>
                        <td>—</td>
                        <td>—</td>
                        <td>—</td>
                    </tr>
                    @empty
                    <tr><td colspan="8" style="color:#999">Nenhum compartimento.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Confined space --}}
    <div class="sec">
        <div class="sec-title">Espaço Confinado</div>
        <div class="sec-body">
            <div class="fr">
                <span class="fl">Espaço Confinado:</span>
                <span class="fv">
                    <span class="ci"><span class="cb on">✓</span> Sim</span>
                    &nbsp;&nbsp;
                    <span class="ci"><span class="cb"></span> Não</span>
                </span>
            </div>
            <div class="fr">
                <span class="fl">Vigia:</span>
                <span class="fv">______________________________</span>
            </div>
            <div class="fr">
                <span class="fl">Operador:</span>
                <span class="fv">{{ $resp?->name ?? '______________________________' }}</span>
            </div>
            <div class="fr">
                <span class="fl">Autorização:</span>
                <span class="fv">______________________________</span>
            </div>
        </div>
    </div>

    {{-- Observations --}}
    <div class="sec">
        <div class="sec-title">Observações</div>
        <div class="sec-body">
            <p style="min-height:20px;font-size:9px">{{ $relatorio->observacoes ?? '' }}</p>
        </div>
    </div>

    {{-- Signatures --}}
    <div class="sigs">
        <div class="sig">
            <div style="height:35px"></div>
            <div class="sig-line">Operador</div>
        </div>
        <div class="sig">
            <div style="height:35px"></div>
            <div class="sig-line">Responsável Técnico</div>
        </div>
        <div class="sig">
            <div style="height:35px"></div>
            <div class="sig-line">Autorização / Vigia</div>
        </div>
    </div>

    <div class="pg-foot">FOR TEC 02 — Lista de Verificação · Relatório {{ $relatorio->numero_relatorio }} · Página 2 de 3</div>
</div>


{{-- ╔═══════════════════════════════════════════════════════════════╗
     ║  PAGE 3 — FOR TEC 03 — Certificado de Descontaminação       ║
     ╚═══════════════════════════════════════════════════════════════╝ --}}
<div class="page" id="for-tec-03">

    {{-- Header --}}
    <div class="hdr">
        <div class="hdr-logo">LOGO<br><small>Empresa</small></div>
        <div class="hdr-center">
            <h1>Certificado de Descontaminação</h1>
            <div class="subtitle">FOR TEC 03</div>
        </div>
        <div class="hdr-right">
            Nº Certificado<br>
            <span class="doc-id">{{ $relatorio->numero_relatorio }}</span><br>
            <small>{{ $relatorio->emitido_em ? $relatorio->emitido_em->format('d/m/Y') : $relatorio->data_servico->format('d/m/Y') }}</small>
        </div>
    </div>

    {{-- Supplier data (fixed) --}}
    <div class="sec">
        <div class="sec-title">Dados do Fornecedor</div>
        <div class="sec-body">
            <div class="fr">
                <span class="fl">Razão Social:</span>
                <span class="fv"><strong>[NOME DA EMPRESA]</strong></span>
            </div>
            <div class="fr">
                <span class="fl">CNPJ:</span>
                <span class="fv">[XX.XXX.XXX/0001-XX]</span>
                <span class="fl" style="min-width:70px">Telefone:</span>
                <span class="fv">[TELEFONE]</span>
            </div>
            <div class="fr">
                <span class="fl">Endereço:</span>
                <span class="fv">[ENDEREÇO COMPLETO]</span>
            </div>
        </div>
    </div>

    {{-- Client data --}}
    <div class="sec">
        <div class="sec-title">Dados do Cliente</div>
        <div class="sec-body">
            <div class="fr">
                <span class="fl">Nome / Razão Social:</span>
                <span class="fv">{{ $c?->nome_razao_social ?? '—' }}</span>
            </div>
            <div class="fr">
                <span class="fl">CNPJ / CPF:</span>
                <span class="fv">{{ $c?->cpf_cnpj ?? '—' }}</span>
                <span class="fl" style="min-width:70px">Tipo:</span>
                <span class="fv" style="flex:0 0 80px">{{ $c?->tipo_pessoa?->label() ?? '—' }}</span>
            </div>
            <div class="fr">
                <span class="fl">Endereço:</span>
                <span class="fv">{{ $c?->endereco ?? '—' }}</span>
            </div>
            <div class="fr">
                <span class="fl">Cidade / UF:</span>
                <span class="fv">{{ $c?->cidade ?? '—' }}{{ $c?->estado ? ' / '.$c->estado : '' }}</span>
                <span class="fl" style="min-width:70px">Telefone:</span>
                <span class="fv" style="flex:0 0 130px">{{ $c?->telefone ?? '—' }}</span>
            </div>
            <div class="fr">
                <span class="fl">Equipamento / Placa:</span>
                <span class="fv" style="font-weight:600">{{ strtoupper($v?->placa ?? '—') }}</span>
                <span class="fl" style="min-width:80px">Nº Série:</span>
                <span class="fv">
                    @if($equipamentos->isNotEmpty())
                        {{ $equipamentos->pluck('numero_serie')->filter()->join(', ') ?: '—' }}
                    @else — @endif
                </span>
            </div>
        </div>
    </div>

    {{-- Finalidade --}}
    <div class="sec">
        <div class="sec-title">Finalidade</div>
        <div class="sec-body">
            <div class="cg">
                @foreach(\App\Enums\FinalidadeRelatorio::cases() as $fin)
                    <span class="ci">
                        <span class="cb {{ in_array($fin->value, $relFinalidades) ? 'on' : '' }}">{{ in_array($fin->value, $relFinalidades) ? '✓' : '' }}</span>
                        {{ $fin->label() }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Process checkboxes --}}
    <div class="sec">
        <div class="sec-title">Processos de Descontaminação</div>
        <div class="sec-body">
            <div class="cg">
                @foreach(\App\Enums\ProcessoRelatorio::cases() as $proc)
                    <span class="ci">
                        <span class="cb {{ $relatorio->processo === $proc ? 'on' : '' }}">{{ $relatorio->processo === $proc ? '✓' : '' }}</span>
                        {{ $proc->label() }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Compartments table (full detail) --}}
    <div class="sec">
        <div class="sec-title">Compartimentos</div>
        <div class="sec-body" style="padding:0">
            <table class="tbl">
                <thead>
                    <tr>
                        <th style="width:22px">Nº</th>
                        <th>Volume (L)</th>
                        <th>Produto Anterior</th>
                        <th>Nº ONU</th>
                        <th>Classe Risco</th>
                        <th>Pressão Vapor</th>
                        <th>Tempo (min)</th>
                        <th>Massa Vapor</th>
                        <th>Vol. Ar (m³)</th>
                        <th>Neutraliz.</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($compartimentos as $comp)
                    <tr>
                        <td><strong>{{ $comp->numero }}</strong></td>
                        <td>{{ $comp->capacidade_litros !== null ? number_format((float)$comp->capacidade_litros, 2, ',', '.') : '—' }}</td>
                        <td style="text-align:left;padding-left:6px">{{ $comp->produto_anterior_nome ?? '—' }}</td>
                        <td>{{ $comp->numero_onu ?? '—' }}</td>
                        <td>{{ $comp->classe_risco ?? '—' }}</td>
                        <td>{{ $comp->pressao_vapor !== null ? number_format((float)$comp->pressao_vapor, 2, ',', '.') : 'NA' }}</td>
                        <td>{{ $comp->tempo_minutos ?? '—' }}</td>
                        <td>{{ $comp->massa_vapor !== null ? number_format((float)$comp->massa_vapor, 2, ',', '.') : 'NA' }}</td>
                        <td>{{ $comp->volume_ar !== null ? number_format((float)$comp->volume_ar, 2, ',', '.') : '—' }}</td>
                        <td>{{ $comp->neutralizante ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="10" style="color:#999">Nenhum compartimento.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Measurement equipment --}}
    <div class="sec">
        <div class="sec-title">Equipamentos de Medição Utilizados</div>
        <div class="sec-body">
            @if($equipamentos->isNotEmpty())
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Equipamento</th>
                            <th>Tipo</th>
                            <th>Nº Série</th>
                            <th>Qtd.</th>
                            <th>Obs.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($equipamentos as $eq)
                        <tr>
                            <td style="text-align:left;padding-left:6px">{{ $eq->nome_snapshot }}</td>
                            <td>{{ $eq->tipo_snapshot?->label() ?? '—' }}</td>
                            <td>{{ $eq->numero_serie ?? '—' }}</td>
                            <td>{{ $eq->quantidade }}</td>
                            <td style="text-align:left;padding-left:6px">{{ $eq->observacao ?? '' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="font-size:9px;color:#999">Nenhum equipamento registrado.</p>
            @endif
        </div>
    </div>

    {{-- Observations --}}
    <div class="sec">
        <div class="sec-title">Observações</div>
        <div class="sec-body">
            <p style="min-height:16px;font-size:9px">{{ $relatorio->observacoes ?? '' }}</p>
        </div>
    </div>

    {{-- Fixed notes --}}
    <div class="sec">
        <div class="sec-title">Notas</div>
        <div class="sec-body">
            <div class="note-block">
                <strong>1.</strong> Este certificado atesta que o veículo e/ou equipamento foi submetido ao processo
                de descontaminação descrito acima, em conformidade com as normas regulamentadoras vigentes.<br>
                <strong>2.</strong> A validade deste certificado está condicionada à não utilização do equipamento
                para transporte de produtos perigosos entre a data de emissão e a data de utilização.<br>
                <strong>3.</strong> O serviço de descontaminação não se responsabiliza por contaminações ocorridas
                após a entrega do equipamento ao cliente.<br>
                <strong>4.</strong> Este documento é parte integrante do processo de segurança no transporte de
                produtos perigosos conforme Portaria 455/2021 e demais legislações aplicáveis.
            </div>
        </div>
    </div>

    {{-- Certification text --}}
    <div style="margin-top:6px;padding:4px 6px;border:1.5px solid var(--c-border)">
        <p style="text-align:justify;font-size:9px;margin:0">
            Certificamos que o veículo de placa <strong>{{ strtoupper($v?->placa ?? '___') }}</strong>,
            do tipo <strong>{{ $v?->tipo_veiculo ?? '___' }}</strong>,
            foi submetido ao processo de descontaminação por <strong>{{ $relatorio->processo->label() }}</strong>,
            atendendo às normas regulamentadoras vigentes, estando apto para o transporte de produtos perigosos
            ou para a finalidade a que se destina.
        </p>
    </div>

    {{-- Signatures --}}
    <div class="sigs" style="margin-top:14px">
        <div class="sig">
            <div style="height:32px"></div>
            <div class="sig-line">
                Operador
            </div>
        </div>
        <div class="sig">
            <div style="height:32px"></div>
            <div class="sig-line">
                <strong>{{ $resp?->name ?? '________________________' }}</strong><br>
                Responsável Técnico
                @if($resp?->profile?->registro_profissional)
                    <br><small>Reg.: {{ $resp->profile->registro_profissional }}</small>
                @endif
            </div>
        </div>
        <div class="sig">
            <div style="height:32px"></div>
            <div class="sig-line">
                Cliente / Contratante
            </div>
        </div>
    </div>

    <div class="pg-foot">FOR TEC 03 — Certificado de Descontaminação · Nº {{ $relatorio->numero_relatorio }} · Página 3 de 3</div>
</div>

{{-- Footer --}}
<div style="text-align:center;max-width:210mm;margin:0 auto;font-size:8px;color:#aaa">
    Documento gerado em {{ now()->format('d/m/Y \à\s H:i') }} — Sistema de Descontaminação
</div>

</body>
</html>
        }
        .cert-header-number strong {
            display: block;
            font-size: 14px;
            color: var(--header-bg);
        }

        /* ================================
           SECTION STYLES
           ================================ */
        .section {
            border: 1.5px solid var(--border-color);
            margin-bottom: 6px;
        }
        .section-title {
            background: var(--header-bg);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 3px 8px;
            letter-spacing: 0.5px;
        }
        .section-body {
            padding: 6px 8px;
        }

        /* Field rows */
        .field-row {
            display: flex;
            flex-wrap: wrap;
            border-bottom: 1px solid #ddd;
            padding: 2px 0;
        }
        .field-row:last-child {
            border-bottom: none;
        }
        .field-label {
            font-weight: 600;
            font-size: 10px;
            color: #333;
            min-width: 140px;
        }
        .field-value {
            flex: 1;
            font-size: 11px;
        }

        /* ================================
           CHECKBOX GRID
           ================================ */
        .check-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 4px 16px;
        }
        .check-item {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 10px;
        }
        .check-box {
            width: 12px;
            height: 12px;
            border: 1.5px solid #333;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            font-weight: 700;
        }
        .check-box.checked {
            background: var(--header-bg);
            color: #fff;
        }

        /* ================================
           INSPECTION BLOCK
           ================================ */
        .inspection-row {
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }
        .inspection-label {
            font-weight: 600;
            font-size: 10px;
            min-width: 110px;
        }
        .yn-box {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            font-size: 10px;
            margin-right: 10px;
        }
        .inspection-desc {
            flex: 1;
            border-bottom: 1px dotted #999;
            min-height: 14px;
            font-size: 10px;
        }

        /* ================================
           COMPARTMENT TABLE
           ================================ */
        .comp-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        .comp-table th,
        .comp-table td {
            border: 1px solid var(--border-color);
            padding: 3px 5px;
            text-align: center;
            vertical-align: middle;
        }
        .comp-table th {
            background: #e8ecf0;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .comp-table td {
            font-size: 10px;
        }

        /* ================================
           SIGNATURES
           ================================ */
        .signatures {
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
            gap: 20px;
        }
        .sig-block {
            text-align: center;
            flex: 1;
        }
        .sig-line {
            border-top: 1px solid #000;
            margin: 0 20px;
            padding-top: 4px;
            font-size: 10px;
        }

        /* ================================
           SCREEN-ONLY TOOLBAR
           ================================ */
        .print-toolbar {
            max-width: 210mm;
            margin: 0 auto 12px;
            padding: 10px;
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }

        /* ================================
           PRINT OVERRIDES
           ================================ */
        @media print {
            body {
                background: #fff;
                padding: 0;
                margin: 0;
            }
            .certificate {
                box-shadow: none;
                padding: 8mm 10mm;
                max-width: 100%;
            }
            .print-toolbar {
                display: none !important;
            }
            .section {
                break-inside: avoid;
            }
        }

        @page {
            size: A4 portrait;
            margin: 10mm;
        }
    </style>
</head>
<body>

{{-- Screen-only toolbar --}}
<div class="print-toolbar">
    <a href="{{ route('relatorios.show', $relatorio) }}" class="btn btn-sm btn-outline-secondary">
        &larr; Voltar
    </a>
    <button type="button" onclick="window.print()" class="btn btn-sm btn-success">
        🖨 Imprimir / Salvar PDF
    </button>
</div>

<div class="certificate">

    {{-- ============================================================
         HEADER
         ============================================================ --}}
    <div class="cert-header">
        <div class="cert-header-logo">
            LOGO<br><small>Empresa</small>
        </div>
        <div class="cert-header-title">
            <h1>Certificado de Descontaminação</h1>
            <p>Serviço de Descontaminação de Veículos para Transporte de Produtos Perigosos</p>
        </div>
        <div class="cert-header-number">
            Nº do Certificado<br>
            <strong>{{ $relatorio->numero_relatorio }}</strong>
        </div>
    </div>

    {{-- ============================================================
         SECTION 1 — DADOS DO SERVIÇO
         ============================================================ --}}
    @php
        $v = $relatorio->veiculoSnapshot;
        $resp = $relatorio->responsavelTecnico;
    @endphp
    <div class="section">
        <div class="section-title">1 — Identificação do Serviço</div>
        <div class="section-body">
            <div class="field-row">
                <span class="field-label">Nome do Condutor / Resp.:</span>
                <span class="field-value">{{ $resp?->name ?? '—' }}</span>
            </div>
            <div class="field-row">
                <span class="field-label">Registro Profissional:</span>
                <span class="field-value">{{ $resp?->profile?->registro_profissional ?? '—' }}</span>
            </div>
            <div class="field-row">
                <span class="field-label">Veículo:</span>
                <span class="field-value">{{ $v?->marca }} {{ $v?->modelo }} {{ $v?->ano ? '('.$v->ano.')' : '' }}</span>
                <span class="field-label" style="min-width:50px">Placa:</span>
                <span class="field-value" style="flex:0 0 120px;font-weight:600">{{ strtoupper($v?->placa ?? '—') }}</span>
            </div>
            <div class="field-row">
                <span class="field-label">Tipo do Veículo:</span>
                <span class="field-value">{{ $v?->tipo_veiculo ?? '—' }}</span>
                <span class="field-label" style="min-width:110px">Nº Equipamento:</span>
                <span class="field-value">
                    @if($relatorio->equipamentosUtilizados->isNotEmpty())
                        {{ $relatorio->equipamentosUtilizados->pluck('nome_snapshot')->join(', ') }}
                    @else
                        —
                    @endif
                </span>
            </div>
            <div class="field-row">
                <span class="field-label">Data do Serviço:</span>
                <span class="field-value">{{ $relatorio->data_servico->format('d/m/Y') }}</span>
                <span class="field-label" style="min-width:110px">Finalidade:</span>
                <span class="field-value">
                    @foreach($relatorio->finalidades as $f)
                        {{ $f->finalidade->label() }}@if(!$loop->last), @endif
                    @endforeach
                </span>
            </div>
        </div>
    </div>

    {{-- ============================================================
         SECTION 2 — PROCESSOS DE DESCONTAMINAÇÃO / VERIFICAÇÃO
         ============================================================ --}}
    <div class="section">
        <div class="section-title">2 — Processo de Descontaminação e Verificação do Veículo</div>
        <div class="section-body">
            {{-- Process checkboxes --}}
            <div class="field-row">
                <span class="field-label">Processo Utilizado:</span>
                <div class="field-value">
                    <div class="check-grid">
                        @foreach(\App\Enums\ProcessoRelatorio::cases() as $proc)
                            <span class="check-item">
                                <span class="check-box {{ $relatorio->processo === $proc ? 'checked' : '' }}">
                                    {{ $relatorio->processo === $proc ? '✓' : '' }}
                                </span>
                                {{ $proc->label() }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>

            <div style="margin-top:6px; border-top:1px solid #ddd; padding-top:4px">
                <strong style="font-size:10px;text-transform:uppercase">Verificação do Veículo</strong>
            </div>

            {{-- External damage --}}
            <div class="field-row" style="margin-top:4px">
                <div class="inspection-row" style="width:100%">
                    <span class="inspection-label">Avarias Externas:</span>
                    <span class="yn-box">
                        <span class="check-box">{{ $relatorio->observacoes ? '✓' : '' }}</span> Sim
                    </span>
                    <span class="yn-box">
                        <span class="check-box">{{ !$relatorio->observacoes ? '✓' : '' }}</span> Não
                    </span>
                    <span class="inspection-desc">{{ $relatorio->observacoes ?? '' }}</span>
                </div>
            </div>

            {{-- Internal damage --}}
            <div class="field-row">
                <div class="inspection-row" style="width:100%">
                    <span class="inspection-label">Avarias Internas:</span>
                    <span class="yn-box">
                        <span class="check-box"></span> Sim
                    </span>
                    <span class="yn-box">
                        <span class="check-box checked">✓</span> Não
                    </span>
                    <span class="inspection-desc"></span>
                </div>
            </div>

            {{-- Seals --}}
            @if($relatorio->lacre_entrada || $relatorio->lacre_saida)
            <div class="field-row">
                @if($relatorio->lacre_entrada)
                    <span class="field-label">Lacre Entrada:</span>
                    <span class="field-value">{{ $relatorio->lacre_entrada }}</span>
                @endif
                @if($relatorio->lacre_saida)
                    <span class="field-label" style="min-width:100px">Lacre Saída:</span>
                    <span class="field-value">{{ $relatorio->lacre_saida }}</span>
                @endif
            </div>
            @endif
        </div>
    </div>

    {{-- ============================================================
         SECTION 3 — DADOS DO CLIENTE
         ============================================================ --}}
    @php $c = $relatorio->clienteSnapshot; @endphp
    <div class="section">
        <div class="section-title">3 — Dados do Cliente</div>
        <div class="section-body">
            <div class="field-row">
                <span class="field-label">Nome / Razão Social:</span>
                <span class="field-value">{{ $c?->nome_razao_social ?? '—' }}</span>
            </div>
            <div class="field-row">
                <span class="field-label">CPF / CNPJ:</span>
                <span class="field-value">{{ $c?->cpf_cnpj ?? '—' }}</span>
                <span class="field-label" style="min-width:50px">Tipo:</span>
                <span class="field-value" style="flex:0 0 80px">{{ $c?->tipo_pessoa?->label() ?? '—' }}</span>
            </div>
            <div class="field-row">
                <span class="field-label">Endereço:</span>
                <span class="field-value">{{ $c?->endereco ?? '—' }}</span>
            </div>
            <div class="field-row">
                <span class="field-label">Cidade / UF:</span>
                <span class="field-value">
                    {{ $c?->cidade ?? '—' }}{{ $c?->estado ? ' / '.$c->estado : '' }}
                </span>
                <span class="field-label" style="min-width:70px">Telefone:</span>
                <span class="field-value" style="flex:0 0 140px">{{ $c?->telefone ?? '—' }}</span>
            </div>
            <div class="field-row">
                <span class="field-label">Equipamento:</span>
                <span class="field-value">
                    @if($relatorio->equipamentosUtilizados->isNotEmpty())
                        @foreach($relatorio->equipamentosUtilizados as $eq)
                            {{ $eq->nome_snapshot }}
                            @if($eq->numero_serie) (Nº {{ $eq->numero_serie }}) @endif
                            @if(!$loop->last), @endif
                        @endforeach
                    @else
                        —
                    @endif
                </span>
            </div>
            <div class="field-row">
                <span class="field-label">Placa / Nº Série:</span>
                <span class="field-value">{{ strtoupper($v?->placa ?? '—') }}</span>
            </div>
        </div>
    </div>

    {{-- ============================================================
         SECTION 4 — COMPARTIMENTOS
         ============================================================ --}}
    <div class="section">
        <div class="section-title">4 — Compartimentos</div>
        <div class="section-body" style="padding:0">
            <table class="comp-table">
                <thead>
                    <tr>
                        <th style="width:30px">Nº</th>
                        <th>Volume (L)</th>
                        <th>Produto Anterior</th>
                        <th>Nº ONU</th>
                        <th>Classe Risco</th>
                        <th>Tempo (min)</th>
                        <th>Vol. Ar (m³)</th>
                        <th>Neutralizante</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($relatorio->compartimentos->sortBy('numero') as $comp)
                    <tr>
                        <td><strong>{{ $comp->numero }}</strong></td>
                        <td>{{ $comp->capacidade_litros !== null ? number_format($comp->capacidade_litros, 2, ',', '.') : '—' }}</td>
                        <td style="text-align:left;padding-left:8px">{{ $comp->produto_anterior_nome ?? '—' }}</td>
                        <td>{{ $comp->numero_onu ?? '—' }}</td>
                        <td>{{ $comp->classe_risco ?? '—' }}</td>
                        <td>{{ $comp->tempo_minutos ?? '—' }}</td>
                        <td>{{ $comp->volume_ar !== null ? number_format($comp->volume_ar, 2, ',', '.') : '—' }}</td>
                        <td>{{ $comp->neutralizante ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-muted">Nenhum compartimento registrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ============================================================
         SECTION 5 — CERTIFICAÇÃO / ASSINATURAS
         ============================================================ --}}
    <div class="section">
        <div class="section-title">5 — Certificação</div>
        <div class="section-body">
            <p style="text-align:justify;font-size:10px;margin:0 0 4px">
                Certificamos que o veículo de placa <strong>{{ strtoupper($v?->placa ?? '___') }}</strong>,
                do tipo <strong>{{ $v?->tipo_veiculo ?? '___' }}</strong>,
                foi submetido ao processo de descontaminação por <strong>{{ $relatorio->processo->label() }}</strong>,
                atendendo às normas regulamentadoras vigentes, estando apto para o transporte de produtos perigosos
                ou para a finalidade a que se destina.
            </p>
            <div class="field-row">
                <span class="field-label">Nº do Certificado:</span>
                <span class="field-value"><strong>{{ $relatorio->numero_relatorio }}</strong></span>
                <span class="field-label" style="min-width:120px">Data de Emissão:</span>
                <span class="field-value">
                    {{ $relatorio->emitido_em ? $relatorio->emitido_em->format('d/m/Y H:i') : $relatorio->data_servico->format('d/m/Y') }}
                </span>
            </div>
            @if($relatorio->observacoes)
            <div class="field-row">
                <span class="field-label">Observações:</span>
                <span class="field-value">{{ $relatorio->observacoes }}</span>
            </div>
            @endif
        </div>
    </div>

    {{-- ============================================================
         SIGNATURES
         ============================================================ --}}
    <div class="signatures">
        <div class="sig-block">
            <div style="height:50px"></div>
            <div class="sig-line">
                <strong>{{ $resp?->name ?? '________________________' }}</strong><br>
                Responsável Técnico
                @if($resp?->profile?->registro_profissional)
                    <br><small>Registro: {{ $resp->profile->registro_profissional }}</small>
                @endif
            </div>
        </div>
        <div class="sig-block">
            <div style="height:50px"></div>
            <div class="sig-line">
                <strong>________________________</strong><br>
                Cliente / Contratante
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div style="text-align:center;margin-top:20px;padding-top:8px;border-top:1px solid #ccc;font-size:8px;color:#888">
        Documento gerado em {{ now()->format('d/m/Y \à\s H:i') }} — Sistema de Descontaminação
    </div>
</div>

</body>
</html>
