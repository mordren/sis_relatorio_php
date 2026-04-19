

<?php $__env->startSection('title', 'Veículos'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-truck"></i> Veículos</h2>
    <a href="<?php echo e(route('veiculos.create')); ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Novo Veículo
    </a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <?php if($veiculos->isEmpty()): ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-truck fs-1"></i>
                <p class="mt-2">Nenhum veículo cadastrado.</p>
                <a href="<?php echo e(route('veiculos.create')); ?>" class="btn btn-outline-primary btn-sm">
                    Cadastrar primeiro veículo
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Placa</th>
                            <th>Marca / Modelo</th>
                            <th>Ano</th>
                            <th>Tipo</th>
                            <th class="text-center">Compart.</th>
                            <th>Nº Equip.</th>
                            <th>Proprietário</th>
                            <th>Situação</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $veiculos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $veiculo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="fw-medium text-uppercase"><?php echo e($veiculo->placa); ?></td>
                            <td><?php echo e($veiculo->marca); ?> / <?php echo e($veiculo->modelo); ?></td>
                            <td><?php echo e($veiculo->ano ?: '—'); ?></td>
                            <td>
                                <span class="badge bg-secondary text-uppercase">
                                    <?php echo e($veiculo->tipo_veiculo); ?>

                                </span>
                            </td>
                            <td class="text-center"><?php echo e($veiculo->numero_compartimentos); ?></td>
                            <td><?php echo e($veiculo->numero_equipamento ?: '—'); ?></td>
                            <td><?php echo e($veiculo->proprietario?->nome_razao_social ?? '—'); ?></td>
                            <td>
                                <?php if($veiculo->ativo): ?>
                                    <span class="badge bg-success">Ativo</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inativo</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end text-nowrap">
                                <a href="<?php echo e(route('veiculos.edit', $veiculo)); ?>"
                                   class="btn btn-outline-primary btn-sm"
                                   title="Editar">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <?php if($veiculos->hasPages()): ?>
                <div class="px-3 py-2">
                    <?php echo e($veiculos->links()); ?>

                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Programacao\sis_relatorio_php\sis_relatorio_php\resources\views/veiculos/index.blade.php ENDPATH**/ ?>