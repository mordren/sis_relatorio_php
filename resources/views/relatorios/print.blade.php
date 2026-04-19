@php
    $v    = $relatorio->veiculoSnapshot;
    $c    = $relatorio->clienteSnapshot;
    $resp = $relatorio->responsavelTecnico;
    $compartimentos = $relatorio->compartimentos->sortBy('numero');
    $equipamentos   = $relatorio->equipamentosUtilizados;
    // $relFinalidades is passed from controller
    // $medicaoEquipamentos (detector, explosimetro, oximetro) is passed from controller
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
        {{-- Logo: place your logo file at public/images/logo.png --}}
        <div class="hdr-logo">
            @if(file_exists(public_path('images/logo.png')))
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="max-width:70px;max-height:70px">
            @else
                LOGO<br><small>Empresa</small>
            @endif
        </div>
        <div class="hdr-center">
            <h1>Verificação Inicial e Entrega de Certificado</h1>
            <div class="subtitle">FOR TEC 01</div>
        </div>
        <div class="hdr-right">
            Nº Certificado<br>
            <span class="doc-id">{{ $relatorio->numero_relatorio }}</span>
        </div>
    </div>

    {{-- Identification --}}
    <div class="sec">
        <div class="sec-title">Identificação</div>
        <div class="sec-body">
            <div class="fr">
                <span class="fl">Nome do Condutor:</span>
                <span class="fv">{{ $relatorio->responsavelTecnico?->name ?? '—' }}</span>
            </div>
            <div class="fr">
                <span class="fl">Nº do Equipamento:</span>
                <span class="fv">{{ $v?->numero_equipamento ?? '—' }}</span>
            </div>
            <div class="fr">
                <span class="fl">Veículo:</span>
                <span class="fv">{{ $v?->marca }} {{ $v?->modelo }}</span>
                <span class="fl" style="min-width:50px">Placa:</span>
                <span class="fv" style="flex:0 0 120px;font-weight:600">{{ strtoupper($v?->placa ?? '—') }}</span>
            </div>
        </div>
    </div>

    {{-- Processos de Descontaminação (always fixed: Com ventilação forçada) --}}
    <div class="sec">
        <div class="sec-title">Processos de Descontaminação</div>
        <div class="sec-body">
            <div class="cg">
                <span class="ci"><span class="cb on">✓</span> Com ventilação forçada</span>
            </div>
        </div>
    </div>

    {{-- Verificação estado geral do veículo (empty — for manual fill on paper) --}}
    <div class="sec">
        <div class="sec-title">Verificação do Estado Geral do Veículo</div>
        <div class="sec-body">
            <div class="fr">
                <div class="insp">
                    <span class="insp-lbl">Avarias Externas:</span>
                    <span class="yn"><span class="cb"></span> Não</span>
                    <span class="yn"><span class="cb"></span> Sim</span>
                    <span style="font-size:9px;margin-left:4px">Quais:</span>
                    <span class="insp-desc"></span>
                </div>
            </div>
            <div class="fr">
                <div class="insp">
                    <span class="insp-lbl">Avarias Internas:</span>
                    <span class="yn"><span class="cb"></span> Não</span>
                    <span class="yn"><span class="cb"></span> Sim</span>
                    <span style="font-size:9px;margin-left:4px">Quais:</span>
                    <span class="insp-desc"></span>
                </div>
            </div>
        </div>
    </div>

    {{-- Declaração (fixed text) --}}
    <div class="sec" style="margin-top:10px">
        <div class="sec-title">Declaração</div>
        <div class="sec-body">
            <p class="note-block">
                Declaro que recebi o veículo/equipamento acima identificado devidamente descontaminado,
                conforme certificado de descontaminação em anexo, estando ciente das condições de entrega
                e dos procedimentos realizados.
            </p>
        </div>
    </div>

    {{-- Data e local --}}
    <div style="margin-top:10px;padding:2px 6px;font-size:10px">
        <span style="font-weight:600">Data e local:</span>
        {{ $relatorio->data_servico->format('d/m/Y') }} - Porto Nacional - TO
    </div>

    {{-- Assinaturas --}}
    <div class="sigs" style="margin-top:30px">
        <div class="sig">
            <div style="height:50px"></div>
            <div class="sig-line">Condutor</div>
        </div>
        <div class="sig">
            <div style="height:50px"></div>
            <div class="sig-line">Representante da Rodosul</div>
        </div>
    </div>

    <div class="pg-foot">FOR TEC 01 · Rev. 01 · Aprovado: Abr/2026 · Nº {{ $relatorio->numero_relatorio }} · Página 1 de 3</div>
</div>


{{-- ╔═══════════════════════════════════════════════════════════════╗
     ║  PAGE 2 — FOR TEC 02 — Lista de Verificação / OS            ║
     ╚═══════════════════════════════════════════════════════════════╝ --}}
<div class="page" id="for-tec-02">

    {{-- Header --}}
    <div class="hdr">
        {{-- Logo: place your logo file at public/images/logo.png --}}
        <div class="hdr-logo">
            @if(file_exists(public_path('images/logo.png')))
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="max-width:70px;max-height:70px">
            @else
                LOGO<br><small>Empresa</small>
            @endif
        </div>
        <div class="hdr-center">
            <h1>Lista de Verificação</h1>
            <div class="subtitle">Ordem de Serviço — FOR TEC 02</div>
        </div>
        <div class="hdr-right">
            Nº Controle OS<br>
            <span class="doc-id">{{ $relatorio->numero_relatorio }}</span>
        </div>
    </div>

    {{-- Top section: dynamic data --}}
    <div class="sec">
        <div class="sec-title">Dados do Serviço</div>
        <div class="sec-body">
            <table class="tbl">
                <tbody>
                    <tr>
                        <td style="text-align:left;font-weight:600;width:140px">Placa:</td>
                        <td style="text-align:left;font-weight:700">{{ strtoupper($v?->placa ?? '—') }}</td>
                        <td style="text-align:left;font-weight:600;width:140px">Nº Controle OS:</td>
                        <td style="text-align:left">{{ $relatorio->numero_relatorio }}</td>
                    </tr>
                    <tr>
                        <td style="text-align:left;font-weight:600">Nº Equipamento:</td>
                        <td style="text-align:left">{{ $v?->numero_equipamento ?? '—' }}</td>
                        <td style="text-align:left;font-weight:600">Data de Início:</td>
                        <td style="text-align:left">______/______/________  ______:______h</td>
                    </tr>
                    <tr>
                        <td style="text-align:left;font-weight:600">Procedimento:</td>
                        <td style="text-align:left">PT-01</td>
                        <td style="text-align:left;font-weight:600">Data do Fim:</td>
                        <td style="text-align:left">______/______/________  ______:______h</td>
                    </tr>
                    <tr>
                        <td style="text-align:left;font-weight:600">Norma:</td>
                        <td colspan="3" style="text-align:left">Portaria 455/2021</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Finalidade (static checkboxes — manual fill on paper) --}}
    <div class="sec">
        <div class="sec-title">Finalidade</div>
        <div class="sec-body">
            <div class="cg">
                <span class="ci"><span class="cb"></span> Inspeção</span>
                <span class="ci"><span class="cb"></span> Manutenção</span>
                <span class="ci"><span class="cb"></span> Reparo</span>
                <span class="ci"><span class="cb"></span> Reforma</span>
                <span class="ci"><span class="cb"></span> Verificação metrológica</span>
            </div>
        </div>
    </div>

    {{-- Compartment table (rows = fields, columns = compartimentos 1º–6º) --}}
    <div class="sec">
        <div class="sec-title">Compartimentos</div>
        <div class="sec-body" style="padding:0">
            <table class="tbl" style="font-size:8px">
                <thead>
                    <tr>
                        <th style="width:170px;text-align:left;padding-left:6px"></th>
                        <th>1º</th>
                        <th>2º</th>
                        <th>3º</th>
                        <th>4º</th>
                        <th>5º</th>
                        <th>6º</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Volume --}}
                    <tr>
                        <td style="text-align:left;padding-left:6px;font-weight:600">Volume (m³)</td>
                        @for($i = 0; $i < 6; $i++)
                            <td>&nbsp;</td>
                        @endfor
                    </tr>
                    {{-- Produto perigoso --}}
                    <tr>
                        <td style="text-align:left;padding-left:6px;font-weight:600">Produto perigoso transp. (último)</td>
                        @for($i = 0; $i < 6; $i++)
                            <td>&nbsp;</td>
                        @endfor
                    </tr>
                    {{-- Nº ONU --}}
                    <tr>
                        <td style="text-align:left;padding-left:6px;font-weight:600">Nº ONU</td>
                        @for($i = 0; $i < 6; $i++)
                            <td>&nbsp;</td>
                        @endfor
                    </tr>
                    {{-- Classe de risco --}}
                    <tr>
                        <td style="text-align:left;padding-left:6px;font-weight:600">Classe de risco</td>
                        @for($i = 0; $i < 6; $i++)
                            <td>&nbsp;</td>
                        @endfor
                    </tr>
                    {{-- Índice CO --}}
                    <tr style="background:#f5f5f5">
                        <td style="text-align:left;padding-left:6px;font-weight:700" rowspan="2">Índice CO</td>
                        @for($i = 0; $i < 6; $i++)
                            <td style="font-size:7px;color:#666">1ª</td>
                        @endfor
                    </tr>
                    <tr style="background:#f5f5f5">
                        @for($i = 0; $i < 6; $i++)
                            <td style="font-size:7px;color:#666">2ª</td>
                        @endfor
                    </tr>
                    {{-- Índice O₂ --}}
                    <tr>
                        <td style="text-align:left;padding-left:6px;font-weight:700" rowspan="2">Índice O₂</td>
                        @for($i = 0; $i < 6; $i++)
                            <td style="font-size:7px;color:#666">1ª</td>
                        @endfor
                    </tr>
                    <tr>
                        @for($i = 0; $i < 6; $i++)
                            <td style="font-size:7px;color:#666">2ª</td>
                        @endfor
                    </tr>
                    {{-- Índice LEL --}}
                    <tr style="background:#f5f5f5">
                        <td style="text-align:left;padding-left:6px;font-weight:700" rowspan="2">Índice LEL</td>
                        @for($i = 0; $i < 6; $i++)
                            <td style="font-size:7px;color:#666">1ª</td>
                        @endfor
                    </tr>
                    <tr style="background:#f5f5f5">
                        @for($i = 0; $i < 6; $i++)
                            <td style="font-size:7px;color:#666">2ª</td>
                        @endfor
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Espaço Confinado --}}
    <div class="sec">
        <div class="sec-title">Espaço Confinado</div>
        <div class="sec-body">
            <div class="fr">
                <span class="fl">Necessidade de entrada em espaço confinado:</span>
                <span class="fv">
                    <span class="ci"><span class="cb"></span> SIM</span>
                    &nbsp;&nbsp;
                    <span class="ci"><span class="cb"></span> NÃO</span>
                </span>
            </div>
            <div class="fr">
                <span class="fl">Vigia:</span>
                <span class="fv">______________________________</span>
            </div>
            <div class="fr">
                <span class="fl">Operador:</span>
                <span class="fv">______________________________</span>
            </div>
            <div class="fr">
                <span class="fl">Autorizado por:</span>
                <span class="fv">______________________________</span>
            </div>
            <div class="fr" style="margin-top:4px">
                <span class="fl">Data de início com horas:</span>
                <span class="fv">______/______/________  ______:______h</span>
            </div>
            <div class="fr">
                <span class="fl">Data do fim com horas:</span>
                <span class="fv">______/______/________  ______:______h</span>
            </div>
        </div>
    </div>

    {{-- Data e local --}}
    <div style="margin-top:10px;padding:2px 6px;font-size:10px">
        <span style="font-weight:600">Data e local:</span>
        Porto Nacional, {{ $relatorio->data_servico->format('d/m/Y') }}
    </div>

    {{-- Assinaturas --}}
    <div class="sigs" style="margin-top:24px">
        <div class="sig">
            <div style="height:45px"></div>
            <div class="sig-line">Assinatura do Operador</div>
        </div>
        <div class="sig">
            <div style="height:45px"></div>
            <div class="sig-line">Assinatura do Responsável Operacional</div>
        </div>
    </div>

    <div class="pg-foot">FOR TEC 02 · Rev. 01 · Aprovado: Abr/2026 · Nº {{ $relatorio->numero_relatorio }} · Página 2 de 3</div>
</div>


{{-- ╔═══════════════════════════════════════════════════════════════╗
     ║  PAGE 3 — FOR TEC 03 — Certificado de Descontaminação       ║
     ╚═══════════════════════════════════════════════════════════════╝ --}}
<div class="page" id="for-tec-03">

    {{-- Header --}}
    <div class="hdr">
        {{-- Logo: place your logo file at public/images/logo.png --}}
        <div class="hdr-logo">
            @if(file_exists(public_path('images/logo.png')))
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="max-width:70px;max-height:70px">
            @else
                LOGO<br><small>Empresa</small>
            @endif
        </div>
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

    {{-- Supplier data (RODOSUL - FIXED) --}}
    <div class="sec">
        <div class="sec-title">Dados do Fornecedor</div>
        <div class="sec-body">
            <div class="fr">
                <span class="fl">Razão Social:</span>
                <span class="fv"><strong>RODOSUL DESCONTAMINAÇÃO LTDA</strong></span>
            </div>
            <div class="fr">
                <span class="fl">CNPJ:</span>
                <span class="fv">00.000.000/0000-00</span>
                <span class="fl" style="min-width:70px">Telefone:</span>
                <span class="fv">(63) 3000-0000</span>
            </div>
            <div class="fr">
                <span class="fl">Endereço:</span>
                <span class="fv">Porto Nacional - TO</span>
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
                <span class="fl" style="min-width:100px">Nº Equipamento:</span>
                <span class="fv" style="flex:0 0 100px">{{ $v?->numero_equipamento ?? '—' }}</span>
            </div>
        </div>
    </div>

    {{-- Finalidade — ALWAYS Inspeção --}}
    <div class="sec">
        <div class="sec-title">Finalidade</div>
        <div class="sec-body">
            <div class="cg">
                <span class="ci"><span class="cb on">✓</span> Inspeção</span>
            </div>
        </div>
    </div>

    {{-- Processo — ALWAYS Com ventilação forçada --}}
    <div class="sec">
        <div class="sec-title">Processos de Descontaminação</div>
        <div class="sec-body">
            <div class="cg">
                <span class="ci"><span class="cb on">✓</span> Com ventilação forçada</span>
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
            <table class="tbl">
                <thead>
                    <tr>
                        <th>Tipo de Equipamento</th>
                        <th>Nº Série</th>
                        <th>Data Calibração</th>
                        <th>Observação</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $detectorOK = $medicaoEquipamentos['detector'];
                        $explosimetroOK = $medicaoEquipamentos['explosimetro'];
                        $oximetroOK = $medicaoEquipamentos['oximetro'];
                    @endphp
                    <tr>
                        <td style="text-align:left;padding-left:6px">Detector de Gases</td>
                        <td>{{ $detectorOK?->numero_serie ?? '—' }}</td>
                        <td>{{ $detectorOK?->data_calibracao?->format('d/m/Y') ?? '—' }}</td>
                        <td style="text-align:left;padding-left:6px">{{ $detectorOK?->observacao ?? '' }}</td>
                    </tr>
                    <tr>
                        <td style="text-align:left;padding-left:6px">Explosímetro</td>
                        <td>{{ $explosimetroOK?->numero_serie ?? '—' }}</td>
                        <td>{{ $explosimetroOK?->data_calibracao?->format('d/m/Y') ?? '—' }}</td>
                        <td style="text-align:left;padding-left:6px">{{ $explosimetroOK?->observacao ?? '' }}</td>
                    </tr>
                    <tr>
                        <td style="text-align:left;padding-left:6px">Oxímetro</td>
                        <td>{{ $oximetroOK?->numero_serie ?? '—' }}</td>
                        <td>{{ $oximetroOK?->data_calibracao?->format('d/m/Y') ?? '—' }}</td>
                        <td style="text-align:left;padding-left:6px">{{ $oximetroOK?->observacao ?? '' }}</td>
                    </tr>
                </tbody>
            </table>
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
        <div class="sec-title">Notas e Regulamentação</div>
        <div class="sec-body">
            <div class="note-block">
                <strong>Regulamentação:</strong> Portaria Inmetro nº 445, de 26 de outubro de 2021<br><br>
                <strong>Nota 1:</strong> Não nos responsabilizamos por contaminações que ocorram após a entrega do equipamento descontaminado ao cliente.<br>
                <strong>Nota 2:</strong> Ocorrendo um intervalo entre a descontaminação e a utilização do equipamento, aconselha-se repetir o processo de descontaminação.<br>
                <strong>Nota 3:</strong> Equipamentos que possuem recargas ou lubrificantes devem ser verificados quanto à compatibilidade com o produto transportado.<br>
                <strong>Nota 4:</strong> Não nos responsabilizaremos por qualquer dano ao veículo durante o processo de descontaminação, salvo quando por negligência clara e comprovada.<br><br>
                <strong>Certificação:</strong> Equipamento descontaminado em conformidade com as normas regulamentadoras vigentes e certificado como apto para o transporte de produtos perigosos.
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
    <div class="sigs" style="margin-top:12px">
        <div class="sig">
            <div style="height:30px"></div>
            <div class="sig-line">
                Operador
            </div>
        </div>
        <div class="sig">
            <div style="height:30px"></div>
            <div class="sig-line">
                <strong>{{ $resp?->name ?? '________________________' }}</strong><br>
                Responsável Operacional
                @if($resp?->profile?->registro_profissional)
                    <br><small>Reg.: {{ $resp->profile->registro_profissional }}</small>
                @endif
            </div>
        </div>
        <div class="sig">
            <div style="height:30px"></div>
            <div class="sig-line">
                @if($c?->cpf)
                    Cliente / Contratante
                @else
                    {{-- For CNPJ clients, signature is intentionally blank per requirements --}}
                    &nbsp;
                @endif
            </div>
        </div>
    </div>

    <div class="pg-foot">FOR TEC 03 · Rev. 01 · Aprovado: Abr/2026 · Nº {{ $relatorio->numero_relatorio }} · Página 3 de 3</div>
</div>

{{-- Footer --}}
<div style="text-align:center;max-width:210mm;margin:0 auto;font-size:8px;color:#aaa">
    Documento gerado em {{ now()->format('d/m/Y \\à\\s H:i') }} — Sistema de Descontaminação
</div>

</body>
</html>
