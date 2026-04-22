

<?php $__env->startSection('title', 'Editar Equipamento de Medição'); ?>
<?php $__env->startSection('page-title', 'Editar Equipamento de Medição'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-4">
    <a href="<?php echo e(route('equipamentos_medicao.index')); ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
</div>

<div class="card-modern" style="max-width: 640px">
    <form method="POST" action="<?php echo e(route('equipamentos_medicao.update', $equipamento)); ?>">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Tipo de Equipamento <span class="text-danger">*</span></label>
                <select name="tipo" class="form-select <?php $__errorArgs = ['tipo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                    <option value="">— Selecione —</option>
                    <option value="detector" <?php echo e(old('tipo', $equipamento->tipo) === 'detector' ? 'selected' : ''); ?>>Detector de Gases</option>
                    <option value="explosimetro" <?php echo e(old('tipo', $equipamento->tipo) === 'explosimetro' ? 'selected' : ''); ?>>Explosímetro</option>
                    <option value="oximetro" <?php echo e(old('tipo', $equipamento->tipo) === 'oximetro' ? 'selected' : ''); ?>>Oxímetro</option>
                </select>
                <?php $__errorArgs = ['tipo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Nº Série <span class="text-danger">*</span></label>
                <input type="text" name="numero_serie" class="form-control <?php $__errorArgs = ['numero_serie'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       value="<?php echo e(old('numero_serie', $equipamento->numero_serie)); ?>" required>
                <?php $__errorArgs = ['numero_serie'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Data de Calibração</label>
                <input type="date" name="data_calibracao" class="form-control <?php $__errorArgs = ['data_calibracao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       value="<?php echo e(old('data_calibracao', $equipamento->data_calibracao?->format('Y-m-d'))); ?>">
                <?php $__errorArgs = ['data_calibracao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Status</label>
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" name="ativo" id="ativo" value="1"
                           <?php echo e(old('ativo', $equipamento->ativo) ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="ativo">Ativo</label>
                </div>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Observação</label>
                <textarea name="observacao" class="form-control <?php $__errorArgs = ['observacao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                          rows="3"><?php echo e(old('observacao', $equipamento->observacao)); ?></textarea>
                <?php $__errorArgs = ['observacao'];
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
            <a href="<?php echo e(route('equipamentos_medicao.index')); ?>" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\joaor\OneDrive\Documentos\php\descontaminacao\resources\views/equipamentos_medicao/edit.blade.php ENDPATH**/ ?>