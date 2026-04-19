<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado de Descontaminação Nº <?php echo e($relatorio->numero_relatorio); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ================================
           GENERAL / SCREEN
           ================================ */
        :root {
            --border-color: #333;
            --header-bg: #0f3b5e;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #000;
            background: #e9ecef;
            margin: 0;
            padding: 20px;
        }

        .certificate {
            max-width: 210mm;
            margin: 0 auto;
            background: #fff;
            padding: 15mm 12mm;
            box-shadow: 0 2px 20px rgba(0,0,0,.15);
        }

        /* ================================
           HEADER
           ================================ */
        .cert-header {
            display: flex;
            align-items: center;
            border: 2px solid var(--border-color);
            margin-bottom: 8px;
        }
        .cert-header-logo {
            width: 90px;
            padding: 8px 12px;
            text-align: center;
            border-right: 2px solid var(--border-color);
            font-weight: 700;
            font-size: 10px;
            color: var(--header-bg);
        }
        .cert-header-title {
            flex: 1;
            text-align: center;
            padding: 8px;
        }
        .cert-header-title h1 {
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            margin: 0 0 2px;
            letter-spacing: 1px;
        }
        .cert-header-title p {
            margin: 0;
            font-size: 10px;
            color: #555;
        }
        .cert-header-number {
            width: 140px;
            padding: 8px 12px;
            text-align: center;
            border-left: 2px solid var(--border-color);
            font-size: 10px;
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


<div class="print-toolbar">
    <a href="<?php echo e(route('relatorios.show', $relatorio)); ?>" class="btn btn-sm btn-outline-secondary">
        &larr; Voltar
    </a>
    <button type="button" onclick="window.print()" class="btn btn-sm btn-success">
        🖨 Imprimir / Salvar PDF
    </button>
</div>

<div class="certificate">

    
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
            <strong><?php echo e($relatorio->numero_relatorio); ?></strong>
        </div>
    </div>

    
    <?php
        $v = $relatorio->veiculoSnapshot;
        $resp = $relatorio->responsavelTecnico;
    ?>
    <div class="section">
        <div class="section-title">1 — Identificação do Serviço</div>
        <div class="section-body">
            <div class="field-row">
                <span class="field-label">Nome do Condutor / Resp.:</span>
                <span class="field-value"><?php echo e($resp?->name ?? '—'); ?></span>
            </div>
            <div class="field-row">
                <span class="field-label">Registro Profissional:</span>
                <span class="field-value"><?php echo e($resp?->profile?->registro_profissional ?? '—'); ?></span>
            </div>
            <div class="field-row">
                <span class="field-label">Veículo:</span>
                <span class="field-value"><?php echo e($v?->marca); ?> <?php echo e($v?->modelo); ?> <?php echo e($v?->ano ? '('.$v->ano.')' : ''); ?></span>
                <span class="field-label" style="min-width:50px">Placa:</span>
                <span class="field-value" style="flex:0 0 120px;font-weight:600"><?php echo e(strtoupper($v?->placa ?? '—')); ?></span>
            </div>
            <div class="field-row">
                <span class="field-label">Tipo do Veículo:</span>
                <span class="field-value"><?php echo e($v?->tipo_veiculo ?? '—'); ?></span>
                <span class="field-label" style="min-width:110px">Nº Equipamento:</span>
                <span class="field-value">
                    <?php if($relatorio->equipamentosUtilizados->isNotEmpty()): ?>
                        <?php echo e($relatorio->equipamentosUtilizados->pluck('nome_snapshot')->join(', ')); ?>

                    <?php else: ?>
                        —
                    <?php endif; ?>
                </span>
            </div>
            <div class="field-row">
                <span class="field-label">Data do Serviço:</span>
                <span class="field-value"><?php echo e($relatorio->data_servico->format('d/m/Y')); ?></span>
                <span class="field-label" style="min-width:110px">Finalidade:</span>
                <span class="field-value">
                    <?php $__currentLoopData = $relatorio->finalidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($f->finalidade->label()); ?><?php if(!$loop->last): ?>, <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </span>
            </div>
        </div>
    </div>

    
    <div class="section">
        <div class="section-title">2 — Processo de Descontaminação e Verificação do Veículo</div>
        <div class="section-body">
            
            <div class="field-row">
                <span class="field-label">Processo Utilizado:</span>
                <div class="field-value">
                    <div class="check-grid">
                        <?php $__currentLoopData = \App\Enums\ProcessoRelatorio::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="check-item">
                                <span class="check-box <?php echo e($relatorio->processo === $proc ? 'checked' : ''); ?>">
                                    <?php echo e($relatorio->processo === $proc ? '✓' : ''); ?>

                                </span>
                                <?php echo e($proc->label()); ?>

                            </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <div style="margin-top:6px; border-top:1px solid #ddd; padding-top:4px">
                <strong style="font-size:10px;text-transform:uppercase">Verificação do Veículo</strong>
            </div>

            
            <div class="field-row" style="margin-top:4px">
                <div class="inspection-row" style="width:100%">
                    <span class="inspection-label">Avarias Externas:</span>
                    <span class="yn-box">
                        <span class="check-box"><?php echo e($relatorio->observacoes ? '✓' : ''); ?></span> Sim
                    </span>
                    <span class="yn-box">
                        <span class="check-box"><?php echo e(!$relatorio->observacoes ? '✓' : ''); ?></span> Não
                    </span>
                    <span class="inspection-desc"><?php echo e($relatorio->observacoes ?? ''); ?></span>
                </div>
            </div>

            
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

            
            <?php if($relatorio->lacre_entrada || $relatorio->lacre_saida): ?>
            <div class="field-row">
                <?php if($relatorio->lacre_entrada): ?>
                    <span class="field-label">Lacre Entrada:</span>
                    <span class="field-value"><?php echo e($relatorio->lacre_entrada); ?></span>
                <?php endif; ?>
                <?php if($relatorio->lacre_saida): ?>
                    <span class="field-label" style="min-width:100px">Lacre Saída:</span>
                    <span class="field-value"><?php echo e($relatorio->lacre_saida); ?></span>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    
    <?php $c = $relatorio->clienteSnapshot; ?>
    <div class="section">
        <div class="section-title">3 — Dados do Cliente</div>
        <div class="section-body">
            <div class="field-row">
                <span class="field-label">Nome / Razão Social:</span>
                <span class="field-value"><?php echo e($c?->nome_razao_social ?? '—'); ?></span>
            </div>
            <div class="field-row">
                <span class="field-label">CPF / CNPJ:</span>
                <span class="field-value"><?php echo e($c?->cpf_cnpj ?? '—'); ?></span>
                <span class="field-label" style="min-width:50px">Tipo:</span>
                <span class="field-value" style="flex:0 0 80px"><?php echo e($c?->tipo_pessoa?->label() ?? '—'); ?></span>
            </div>
            <div class="field-row">
                <span class="field-label">Endereço:</span>
                <span class="field-value"><?php echo e($c?->endereco ?? '—'); ?></span>
            </div>
            <div class="field-row">
                <span class="field-label">Cidade / UF:</span>
                <span class="field-value">
                    <?php echo e($c?->cidade ?? '—'); ?><?php echo e($c?->estado ? ' / '.$c->estado : ''); ?>

                </span>
                <span class="field-label" style="min-width:70px">Telefone:</span>
                <span class="field-value" style="flex:0 0 140px"><?php echo e($c?->telefone ?? '—'); ?></span>
            </div>
            <div class="field-row">
                <span class="field-label">Equipamento:</span>
                <span class="field-value">
                    <?php if($relatorio->equipamentosUtilizados->isNotEmpty()): ?>
                        <?php $__currentLoopData = $relatorio->equipamentosUtilizados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e($eq->nome_snapshot); ?>

                            <?php if($eq->numero_serie): ?> (Nº <?php echo e($eq->numero_serie); ?>) <?php endif; ?>
                            <?php if(!$loop->last): ?>, <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        —
                    <?php endif; ?>
                </span>
            </div>
            <div class="field-row">
                <span class="field-label">Placa / Nº Série:</span>
                <span class="field-value"><?php echo e(strtoupper($v?->placa ?? '—')); ?></span>
            </div>
        </div>
    </div>

    
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
                    <?php $__empty_1 = true; $__currentLoopData = $relatorio->compartimentos->sortBy('numero'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($comp->numero); ?></strong></td>
                        <td><?php echo e($comp->capacidade_litros !== null ? number_format($comp->capacidade_litros, 2, ',', '.') : '—'); ?></td>
                        <td style="text-align:left;padding-left:8px"><?php echo e($comp->produto_anterior_nome ?? '—'); ?></td>
                        <td><?php echo e($comp->numero_onu ?? '—'); ?></td>
                        <td><?php echo e($comp->classe_risco ?? '—'); ?></td>
                        <td><?php echo e($comp->tempo_minutos ?? '—'); ?></td>
                        <td><?php echo e($comp->volume_ar !== null ? number_format($comp->volume_ar, 2, ',', '.') : '—'); ?></td>
                        <td><?php echo e($comp->neutralizante ?? '—'); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-muted">Nenhum compartimento registrado.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="section">
        <div class="section-title">5 — Certificação</div>
        <div class="section-body">
            <p style="text-align:justify;font-size:10px;margin:0 0 4px">
                Certificamos que o veículo de placa <strong><?php echo e(strtoupper($v?->placa ?? '___')); ?></strong>,
                do tipo <strong><?php echo e($v?->tipo_veiculo ?? '___'); ?></strong>,
                foi submetido ao processo de descontaminação por <strong><?php echo e($relatorio->processo->label()); ?></strong>,
                atendendo às normas regulamentadoras vigentes, estando apto para o transporte de produtos perigosos
                ou para a finalidade a que se destina.
            </p>
            <div class="field-row">
                <span class="field-label">Nº do Certificado:</span>
                <span class="field-value"><strong><?php echo e($relatorio->numero_relatorio); ?></strong></span>
                <span class="field-label" style="min-width:120px">Data de Emissão:</span>
                <span class="field-value">
                    <?php echo e($relatorio->emitido_em ? $relatorio->emitido_em->format('d/m/Y H:i') : $relatorio->data_servico->format('d/m/Y')); ?>

                </span>
            </div>
            <?php if($relatorio->observacoes): ?>
            <div class="field-row">
                <span class="field-label">Observações:</span>
                <span class="field-value"><?php echo e($relatorio->observacoes); ?></span>
            </div>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="signatures">
        <div class="sig-block">
            <div style="height:50px"></div>
            <div class="sig-line">
                <strong><?php echo e($resp?->name ?? '________________________'); ?></strong><br>
                Responsável Técnico
                <?php if($resp?->profile?->registro_profissional): ?>
                    <br><small>Registro: <?php echo e($resp->profile->registro_profissional); ?></small>
                <?php endif; ?>
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

    
    <div style="text-align:center;margin-top:20px;padding-top:8px;border-top:1px solid #ccc;font-size:8px;color:#888">
        Documento gerado em <?php echo e(now()->format('d/m/Y \à\s H:i')); ?> — Sistema de Descontaminação
    </div>
</div>

</body>
</html>
<?php /**PATH E:\Programacao\sis_relatorio_php\sis_relatorio_php\resources\views/relatorios/print.blade.php ENDPATH**/ ?>