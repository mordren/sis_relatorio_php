

<?php $__env->startSection('title', 'Equipamentos de Medição'); ?>
<?php $__env->startSection('page-title', 'Equipamentos de Medição'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div></div>
    <a href="<?php echo e(route('equipamentos_medicao.create')); ?>" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> Novo Equipamento
    </a>
</div>

<div class="card-modern">
    <div class="table-responsive table-modern">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Tipo</th>
                    <th>Nº Série</th>
                    <th>Data Calibração</th>
                    <th>Observação</th>
                    <th>Status</th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $equipamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($eq->getTypeLabel()); ?></td>
                    <td><strong><?php echo e($eq->numero_serie); ?></strong></td>
                    <td><?php echo e($eq->data_calibracao?->format('d/m/Y') ?? '—'); ?></td>
                    <td class="text-muted"><?php echo e($eq->observacao ?? '—'); ?></td>
                    <td>
                        <?php if($eq->ativo): ?>
                            <span class="badge bg-success">Ativo</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">Inativo</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-end">
                        <a href="<?php echo e(route('equipamentos_medicao.edit', $eq)); ?>" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form method="POST" action="<?php echo e(route('equipamentos_medicao.destroy', $eq)); ?>" class="d-inline"
                              onsubmit="return confirm('Confirmar exclusão do equipamento <?php echo e(addslashes($eq->numero_serie)); ?>?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Nenhum equipamento registrado.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($equipamentos->hasPages()): ?>
    <div class="mt-3 px-2">
        <?php echo e($equipamentos->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\joaor\OneDrive\Documentos\php\descontaminacao\resources\views/equipamentos_medicao/index.blade.php ENDPATH**/ ?>