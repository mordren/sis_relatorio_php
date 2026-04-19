<?php $__env->startSection('title', 'Relatório Nº ' . $relatorio->numero_relatorio); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-file-earmark-text"></i>
        Relatório <strong>#<?php echo e($relatorio->numero_relatorio); ?></strong>
    </h2>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Painel
        </a>
        <?php if($relatorio->status === \App\Enums\StatusRelatorio::RASCUNHO): ?>
            <a href="<?php echo e(route('relatorios.edit', $relatorio)); ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-pencil"></i> Editar
            </a>
        <?php endif; ?>
        <?php if($relatorio->status === \App\Enums\StatusRelatorio::EMITIDO): ?>
            <a href="<?php echo e(route('relatorios.print', $relatorio)); ?>" class="btn btn-success btn-sm" target="_blank">
                <i class="bi bi-printer"></i> Imprimir Certificado
            </a>
        <?php endif; ?>
    </div>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>


<div class="row g-3 mb-4">
    <div class="col-md-8">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="bi bi-info-circle"></i> Dados do Relatório</h6>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Nº do Relatório</dt>
                    <dd class="col-sm-8"><strong><?php echo e($relatorio->numero_relatorio); ?></strong></dd>

                    <dt class="col-sm-4">Status</dt>
                    <dd class="col-sm-8">
                        <span class="badge <?php echo e($relatorio->status->badgeClass()); ?>">
                            <?php echo e($relatorio->status->label()); ?>

                        </span>
                    </dd>

                    <dt class="col-sm-4">Data do Serviço</dt>
                    <dd class="col-sm-8"><?php echo e($relatorio->data_servico->format('d/m/Y')); ?></dd>

                    <dt class="col-sm-4">Processo</dt>
                    <dd class="col-sm-8"><?php echo e($relatorio->processo->label()); ?></dd>

                    <dt class="col-sm-4">Responsável</dt>
                    <dd class="col-sm-8"><?php echo e($relatorio->responsavelTecnico->name ?? '-'); ?></dd>

                    <?php if($relatorio->lacre_entrada): ?>
                        <dt class="col-sm-4">Lacre Entrada</dt>
                        <dd class="col-sm-8"><?php echo e($relatorio->lacre_entrada); ?></dd>
                    <?php endif; ?>

                    <?php if($relatorio->lacre_saida): ?>
                        <dt class="col-sm-4">Lacre Saída</dt>
                        <dd class="col-sm-8"><?php echo e($relatorio->lacre_saida); ?></dd>
                    <?php endif; ?>

                    <?php if($relatorio->observacoes): ?>
                        <dt class="col-sm-4">Observações</dt>
                        <dd class="col-sm-8"><?php echo e($relatorio->observacoes); ?></dd>
                    <?php endif; ?>

                    <dt class="col-sm-4">Finalidades</dt>
                    <dd class="col-sm-8">
                        <?php $__currentLoopData = $relatorio->finalidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fim): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="badge bg-info text-dark me-1">
                                <?php echo e($fim->finalidade->label()); ?>

                                <?php if($fim->descricao_outros): ?> — <?php echo e($fim->descricao_outros); ?> <?php endif; ?>
                            </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <?php if($relatorio->clienteSnapshot): ?>
                    <?php $c = $relatorio->clienteSnapshot; ?>
                    <dl class="row mb-0 small">
                        <dt class="col-sm-5">Nome/Razão</dt>
                        <dd class="col-sm-7"><?php echo e($c->nome_razao_social); ?></dd>

                        <dt class="col-sm-5">CPF/CNPJ</dt>
                        <dd class="col-sm-7"><?php echo e($c->cpf_cnpj); ?></dd>

                        <?php if($c->cidade): ?>
                            <dt class="col-sm-5">Cidade/UF</dt>
                            <dd class="col-sm-7"><?php echo e($c->cidade); ?>/<?php echo e($c->estado); ?></dd>
                        <?php endif; ?>

                        <?php if($c->telefone): ?>
                            <dt class="col-sm-5">Telefone</dt>
                            <dd class="col-sm-7"><?php echo e($c->telefone); ?></dd>
                        <?php endif; ?>
                    </dl>
                <?php else: ?>
                    <p class="text-muted small mb-0">Snapshot não disponível.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<?php if($relatorio->veiculoSnapshot): ?>
    <?php $v = $relatorio->veiculoSnapshot; ?>
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h6 class="mb-0"><i class="bi bi-truck"></i> Veículo (snapshot)</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-2"><strong>Placa</strong><br><?php echo e($v->placa); ?></div>
                <div class="col-sm-3"><strong>Marca / Modelo</strong><br><?php echo e($v->marca); ?> <?php echo e($v->modelo); ?></div>
                <div class="col-sm-2"><strong>Ano</strong><br><?php echo e($v->ano ?? '-'); ?></div>
                <div class="col-sm-5"><strong>Tipo</strong><br><?php echo e($v->tipo_veiculo ?? '-'); ?></div>
            </div>
        </div>
    </div>
<?php endif; ?>


<div class="card shadow-sm mb-4">
    <div class="card-header bg-white d-flex align-items-center justify-content-between">
        <h6 class="mb-0"><i class="bi bi-layout-split"></i> Compartimentos (snapshot)</h6>
        <small class="text-muted"><?php echo e($relatorio->compartimentos->count()); ?> compartimento(s)</small>
    </div>
    <?php if($relatorio->compartimentos->isEmpty()): ?>
        <div class="card-body text-muted">Nenhum compartimento registrado.</div>
    <?php else: ?>
        <div class="accordion accordion-flush" id="accordionShowCompartimentos">
        <?php $__currentLoopData = $relatorio->compartimentos->sortBy('numero'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $comp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button <?php echo e($i > 0 ? 'collapsed' : ''); ?>"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#scomp-<?php echo e($i); ?>"
                            aria-expanded="<?php echo e($i === 0 ? 'true' : 'false'); ?>">
                        <i class="bi bi-circle me-2"></i>
                        Compartimento <strong class="ms-1">#<?php echo e($comp->numero); ?></strong>
                        <?php if($comp->produto_anterior_nome): ?>
                            <span class="ms-2 text-muted small fw-normal">— <?php echo e($comp->produto_anterior_nome); ?></span>
                        <?php endif; ?>
                    </button>
                </h2>
                <div id="scomp-<?php echo e($i); ?>"
                     class="accordion-collapse collapse <?php echo e($i === 0 ? 'show' : ''); ?>"
                     data-bs-parent="#accordionShowCompartimentos">
                    <div class="accordion-body">
                        <div class="row g-3">
                            <?php if($comp->capacidade_litros !== null): ?>
                                <div class="col-6 col-sm-3 col-md-2">
                                    <div class="text-muted small">Capacidade (L)</div>
                                    <div><?php echo e(number_format($comp->capacidade_litros, 2, ',', '.')); ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if($comp->produto_anterior_nome): ?>
                                <div class="col-6 col-sm-4">
                                    <div class="text-muted small">Produto</div>
                                    <div><?php echo e($comp->produto_anterior_nome); ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if($comp->numero_onu): ?>
                                <div class="col-6 col-sm-2">
                                    <div class="text-muted small">Nº ONU</div>
                                    <div><?php echo e($comp->numero_onu); ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if($comp->classe_risco): ?>
                                <div class="col-6 col-sm-3">
                                    <div class="text-muted small">Classe de Risco</div>
                                    <div><?php echo e($comp->classe_risco); ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if($comp->pressao_vapor !== null): ?>
                                <div class="col-6 col-sm-2">
                                    <div class="text-muted small">Pressão Vapor</div>
                                    <div><?php echo e($comp->pressao_vapor); ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if($comp->tempo_minutos !== null): ?>
                                <div class="col-6 col-sm-2">
                                    <div class="text-muted small">Tempo (min)</div>
                                    <div><?php echo e($comp->tempo_minutos); ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if($comp->massa_vapor !== null): ?>
                                <div class="col-6 col-sm-2">
                                    <div class="text-muted small">Massa Vapor (kg)</div>
                                    <div><?php echo e($comp->massa_vapor); ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if($comp->volume_ar !== null): ?>
                                <div class="col-6 col-sm-2">
                                    <div class="text-muted small">Volume Ar (m³)</div>
                                    <div><?php echo e($comp->volume_ar); ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if($comp->neutralizante): ?>
                                <div class="col-6 col-sm-3">
                                    <div class="text-muted small">Neutralizante</div>
                                    <div><?php echo e($comp->neutralizante); ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if($comp->lacre_entrada_numero): ?>
                                <div class="col-6 col-sm-3">
                                    <div class="text-muted small">Lacre Entrada</div>
                                    <div><?php echo e($comp->lacre_entrada_numero); ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if($comp->lacre_saida_numero): ?>
                                <div class="col-6 col-sm-3">
                                    <div class="text-muted small">Lacre Saída</div>
                                    <div><?php echo e($comp->lacre_saida_numero); ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if($comp->observacao): ?>
                                <div class="col-12">
                                    <div class="text-muted small">Observação</div>
                                    <div><?php echo e($comp->observacao); ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if(!$comp->capacidade_litros && !$comp->produto_anterior_nome && !$comp->numero_onu && !$comp->tempo_minutos): ?>
                                <div class="col-12 text-muted small fst-italic">
                                    Sem dados preenchidos — edite o relatório para completar este compartimento.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Programacao\sis_relatorio_php\sis_relatorio_php\resources\views/relatorios/show.blade.php ENDPATH**/ ?>