

<?php $__env->startSection('title', 'Editar Usuário — ' . $user->name); ?>
<?php $__env->startSection('page-title', 'Editar Usuário'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-4">
    <a href="<?php echo e(route('users.index')); ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
</div>

<div class="card-modern" style="max-width: 680px">
    <form method="POST" action="<?php echo e(route('users.update', $user)); ?>">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

        <h6 class="fw-bold mb-3 text-primary"><i class="bi bi-person-fill me-2"></i>Dados de Acesso</h6>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Nome <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       name="name" value="<?php echo e(old('name', $user->name)); ?>" required>
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">E-mail <span class="text-danger">*</span></label>
                <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       name="email" value="<?php echo e(old('email', $user->email)); ?>" required>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Nova Senha <small class="text-muted">(deixe em branco para manter)</small></label>
                <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       name="password" autocomplete="new-password">
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Confirmar Nova Senha</label>
                <input type="password" class="form-control" name="password_confirmation">
            </div>
        </div>

        <h6 class="fw-bold mb-3 text-primary"><i class="bi bi-shield-check me-2"></i>Permissões</h6>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Tipo de Usuário</label>
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" name="is_admin" id="is_admin"
                           value="1" <?php echo e(old('is_admin', $user->is_admin) ? 'checked' : ''); ?>

                           <?php echo e($user->id === auth()->id() ? 'disabled' : ''); ?>>
                    <label class="form-check-label" for="is_admin">Administrador</label>
                    <?php if($user->id === auth()->id()): ?>
                        
                        <?php if($user->is_admin): ?>
                            <input type="hidden" name="is_admin" value="1">
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Status</label>
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" name="ativo" id="ativo"
                           value="1" <?php echo e(old('ativo', $user->profile?->ativo ?? true) ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="ativo">Ativo</label>
                </div>
            </div>
        </div>

        <h6 class="fw-bold mb-3 text-primary"><i class="bi bi-person-badge me-2"></i>Perfil Profissional</h6>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Cargo</label>
                <input type="text" class="form-control <?php $__errorArgs = ['cargo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       name="cargo" value="<?php echo e(old('cargo', $user->profile?->cargo)); ?>">
                <?php $__errorArgs = ['cargo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Registro Profissional</label>
                <input type="text" class="form-control <?php $__errorArgs = ['registro_profissional'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       name="registro_profissional" value="<?php echo e(old('registro_profissional', $user->profile?->registro_profissional)); ?>">
                <?php $__errorArgs = ['registro_profissional'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Telefone</label>
                <input type="text" class="form-control <?php $__errorArgs = ['telefone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       name="telefone" value="<?php echo e(old('telefone', $user->profile?->telefone)); ?>" maxlength="20">
                <?php $__errorArgs = ['telefone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg"></i> Salvar Alterações
            </button>
            <a href="<?php echo e(route('users.index')); ?>" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\joaor\OneDrive\Documentos\php\descontaminacao\resources\views/users/edit.blade.php ENDPATH**/ ?>