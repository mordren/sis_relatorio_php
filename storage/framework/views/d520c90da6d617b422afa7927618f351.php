<?php $__env->startSection('title', 'Painel'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-speedometer2"></i> Painel</h2>
    <a href="<?php echo e(route('relatorios.create')); ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Novo Relatório
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="bi bi-clock-history"></i> Últimos Relatórios</h5>
    </div>
    <div class="card-body p-0">
        <?php if($relatorios->isEmpty()): ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1"></i>
                <p class="mt-2">Nenhum relatório encontrado.</p>
                <a href="<?php echo e(route('relatorios.create')); ?>" class="btn btn-outline-primary btn-sm">
                    Criar primeiro relatório
                </a>
            </div>
        <?php else: ?>
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
                        <?php $__currentLoopData = $relatorios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatorio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <a href="<?php echo e(route('relatorios.show', $relatorio)); ?>" class="fw-bold text-decoration-none">
                                    #<?php echo e($relatorio->numero_relatorio); ?>

                                </a>
                            </td>
                            <td>
                                <span class="badge <?php echo e($relatorio->status->badgeClass()); ?>">
                                    <?php echo e($relatorio->status->label()); ?>

                                </span>
                            </td>
                            <td><?php echo e($relatorio->data_servico->format('d/m/Y')); ?></td>
                            <td>
                                <?php if($relatorio->veiculoSnapshot): ?>
                                    <span class="text-nowrap">
                                        <?php echo e($relatorio->veiculoSnapshot->placa); ?>

                                        <small class="text-muted">
                                            (<?php echo e($relatorio->veiculoSnapshot->marca); ?> <?php echo e($relatorio->veiculoSnapshot->modelo); ?>)
                                        </small>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($relatorio->processo->label()); ?></td>
                            <td><?php echo e($relatorio->responsavelTecnico->name ?? '-'); ?></td>
                            <td><?php echo e($relatorio->created_at->format('d/m/Y H:i')); ?></td>
                            <td class="text-end text-nowrap">
                                <a href="<?php echo e(route('relatorios.show', $relatorio)); ?>"
                                   class="btn btn-outline-secondary btn-sm"
                                   title="Ver">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <?php if($relatorio->status === \App\Enums\StatusRelatorio::RASCUNHO): ?>
                                    <a href="<?php echo e(route('relatorios.edit', $relatorio)); ?>"
                                       class="btn btn-outline-primary btn-sm"
                                       title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Programacao\sis_relatorio_php\sis_relatorio_php\resources\views/dashboard.blade.php ENDPATH**/ ?>