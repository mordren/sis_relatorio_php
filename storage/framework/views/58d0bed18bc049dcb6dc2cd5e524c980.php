

<?php $__env->startSection('title', 'Editar Veículo'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0"><i class="bi bi-pencil-square"></i> Editar Veículo</h4>
            <a href="<?php echo e(route('veiculos.index')); ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Voltar à lista
            </a>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-truck"></i>
                    <?php echo e(strtoupper($veiculo->placa)); ?>

                    <small class="text-muted fw-normal fs-6">— <?php echo e($veiculo->marca); ?> <?php echo e($veiculo->modelo); ?></small>
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('veiculos.update', $veiculo)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="placa" class="form-label">Placa <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control text-uppercase <?php $__errorArgs = ['placa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="placa"
                                   name="placa"
                                   value="<?php echo e(old('placa', $veiculo->placa)); ?>"
                                   maxlength="10"
                                   required>
                            <?php $__errorArgs = ['placa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-4">
                            <label for="marca" class="form-label">Marca <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control <?php $__errorArgs = ['marca'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="marca"
                                   name="marca"
                                   value="<?php echo e(old('marca', $veiculo->marca)); ?>"
                                   required>
                            <?php $__errorArgs = ['marca'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-4">
                            <label for="modelo" class="form-label">Modelo <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control <?php $__errorArgs = ['modelo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="modelo"
                                   name="modelo"
                                   value="<?php echo e(old('modelo', $veiculo->modelo)); ?>"
                                   required>
                            <?php $__errorArgs = ['modelo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="ano" class="form-label">Ano de Fabricação</label>
                            <input type="number"
                                   class="form-control <?php $__errorArgs = ['ano'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="ano"
                                   name="ano"
                                   value="<?php echo e(old('ano', $veiculo->ano)); ?>"
                                   min="1950"
                                   max="<?php echo e(date('Y') + 1); ?>">
                            <?php $__errorArgs = ['ano'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-4">
                            <label for="tipo_veiculo" class="form-label">Tipo de Veículo <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['tipo_veiculo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="tipo_veiculo"
                                    name="tipo_veiculo"
                                    required>
                                <option value="">Selecione...</option>
                                <?php $__currentLoopData = $tiposVeiculo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($tipo); ?>"
                                        <?php echo e(old('tipo_veiculo', $veiculo->tipo_veiculo) === $tipo ? 'selected' : ''); ?>>
                                        <?php echo e(ucfirst(strtolower($tipo))); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['tipo_veiculo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-4">
                            <label for="numero_compartimentos" class="form-label">Nº de Compartimentos <span class="text-danger">*</span></label>
                            <input type="number"
                                   class="form-control <?php $__errorArgs = ['numero_compartimentos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="numero_compartimentos"
                                   name="numero_compartimentos"
                                   value="<?php echo e(old('numero_compartimentos', $veiculo->numero_compartimentos)); ?>"
                                   min="1"
                                   required>
                            <?php $__errorArgs = ['numero_compartimentos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="numero_equipamento" class="form-label">Nº do Equipamento</label>
                            <input type="text"
                                   class="form-control <?php $__errorArgs = ['numero_equipamento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="numero_equipamento"
                                   name="numero_equipamento"
                                   value="<?php echo e(old('numero_equipamento', $veiculo->numero_equipamento)); ?>"
                                   maxlength="50"
                                   placeholder="Ex: EQ-0001">
                            <?php $__errorArgs = ['numero_equipamento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="proprietario_id" class="form-label">Proprietário</label>
                        <select class="form-select <?php $__errorArgs = ['proprietario_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="proprietario_id"
                                name="proprietario_id">
                            <option value="">Sem proprietário vinculado</option>
                            <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cliente->id); ?>"
                                    <?php echo e(old('proprietario_id', $veiculo->proprietario_id) == $cliente->id ? 'selected' : ''); ?>>
                                    <?php echo e($cliente->nome_razao_social); ?> — <?php echo e($cliente->cpf_cnpj); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['proprietario_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="ativo"
                                   name="ativo"
                                   value="1"
                                   <?php echo e(old('ativo', $veiculo->ativo) ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="ativo">Veículo ativo</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('veiculos.index')); ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Programacao\sis_relatorio_php\sis_relatorio_php\resources\views/veiculos/edit.blade.php ENDPATH**/ ?>