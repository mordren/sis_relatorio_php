

<?php $__env->startSection('title', 'Gerenciamento de Usuários'); ?>
<?php $__env->startSection('page-title', 'Gerenciamento de Usuários'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div></div>
    <a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary btn-sm">
        <i class="bi bi-person-plus-fill"></i> Novo Usuário
    </a>
</div>

<div class="card-modern">
    <div class="table-responsive table-modern">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Tipo</th>
                    <th>Cargo</th>
                    <th>Status</th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-person-circle text-secondary fs-5"></i>
                            <strong><?php echo e($user->name); ?></strong>
                        </div>
                    </td>
                    <td class="text-muted"><?php echo e($user->email); ?></td>
                    <td>
                        <?php if($user->is_admin): ?>
                            <span class="badge bg-danger">Administrador</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Usuário</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo e($user->profile?->cargo ?? '—'); ?></td>
                    <td>
                        <?php if($user->profile?->ativo ?? true): ?>
                            <span class="badge bg-success">Ativo</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">Inativo</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-end">
                        <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <?php if($user->id !== auth()->id()): ?>
                        <form method="POST" action="<?php echo e(route('users.destroy', $user)); ?>" class="d-inline"
                              onsubmit="return confirm('Confirmar exclusão do usuário <?php echo e(addslashes($user->name)); ?>?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Nenhum usuário encontrado.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($users->hasPages()): ?>
    <div class="mt-3 px-2">
        <?php echo e($users->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\joaor\OneDrive\Documentos\php\descontaminacao\resources\views/users/index.blade.php ENDPATH**/ ?>