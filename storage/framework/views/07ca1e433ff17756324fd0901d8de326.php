

<?php $__env->startSection('title', 'Clientes'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-people-fill"></i> Clientes</h2>
    <a href="<?php echo e(route('clientes.create')); ?>" class="btn btn-primary">
        <i class="bi bi-person-plus"></i> Novo Cliente
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
        <?php if($clientes->isEmpty()): ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-people fs-1"></i>
                <p class="mt-2">Nenhum cliente cadastrado.</p>
                <a href="<?php echo e(route('clientes.create')); ?>" class="btn btn-outline-primary btn-sm">
                    Cadastrar primeiro cliente
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nome / Razão Social</th>
                            <th>CPF / CNPJ</th>
                            <th>Tipo</th>
                            <th>Cidade / UF</th>
                            <th>Telefone</th>
                            <th>Situação</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="fw-medium"><?php echo e($cliente->nome_razao_social); ?></td>
                            <td class="text-nowrap"><?php echo e($cliente->cpf_cnpj); ?></td>
                            <td>
                                <span class="badge bg-secondary">
                                    <?php echo e($cliente->tipo_pessoa->label()); ?>

                                </span>
                            </td>
                            <td>
                                <?php if($cliente->cidade): ?>
                                    <?php echo e($cliente->cidade); ?><?php echo e($cliente->estado ? '/' . $cliente->estado : ''); ?>

                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($cliente->telefone ?: '—'); ?></td>
                            <td>
                                <?php if($cliente->ativo): ?>
                                    <span class="badge bg-success">Ativo</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inativo</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end text-nowrap">
                                <a href="<?php echo e(route('clientes.edit', $cliente)); ?>"
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

            <?php if($clientes->hasPages()): ?>
                <div class="px-3 py-2">
                    <?php echo e($clientes->links()); ?>

                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\joaor\OneDrive\Documentos\php\descontaminacao\resources\views/clientes/index.blade.php ENDPATH**/ ?>