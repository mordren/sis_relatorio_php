<?php $__env->startSection('title', 'Cadastrar Veículo'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-7">
        
        <?php if($activeClientCount > 0): ?>
            <div class="alert alert-info alert-dismissible fade show rounded-4 d-flex align-items-center">
                <i class="bi bi-info-circle-fill me-3 fs-5"></i>
                <span>
                    <strong><?php echo e($activeClientCount); ?></strong> 
                    <?php echo e($activeClientCount === 1 ? 'cliente ativo disponível' : 'clientes ativos disponíveis'); ?> 
                    para associar como proprietário.
                </span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-4 d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-3 fs-5"></i>
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card card-modern">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-truck me-2"></i> Cadastrar Veículo
                </h5>
            </div>
            <div class="card-body px-4 pb-4">
                <form method="POST" action="<?php echo e(route('veiculos.store')); ?>">
                    <?php echo csrf_field(); ?>

                    
                    <input type="hidden" name="return_to" value="<?php echo e($returnTo); ?>">
                    <input type="hidden" name="return_cliente_id" value="<?php echo e($returnClienteId); ?>">

                    <div class="row g-3 mb-4">
                        
                        <div class="col-md-4">
                            <label for="placa" class="form-label fw-medium">Placa <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control <?php $__errorArgs = ['placa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="placa"
                                   name="placa"
                                   value="<?php echo e(old('placa')); ?>"
                                   maxlength="10"
                                   style="text-transform:uppercase"
                                   placeholder="ABC1D23"
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
                            <label for="marca" class="form-label fw-medium">Marca <span class="text-danger">*</span></label>
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
                                   value="<?php echo e(old('marca')); ?>"
                                   placeholder="Ex: Volvo"
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
                            <label for="modelo" class="form-label fw-medium">Modelo <span class="text-danger">*</span></label>
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
                                   value="<?php echo e(old('modelo')); ?>"
                                   placeholder="Ex: FH 540"
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

                    <div class="row g-3 mb-4">
                        
                        <div class="col-md-3">
                            <label for="ano" class="form-label fw-medium">Ano</label>
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
                                   value="<?php echo e(old('ano')); ?>"
                                   min="1900"
                                   max="<?php echo e(date('Y') + 2); ?>"
                                   placeholder="<?php echo e(date('Y')); ?>">
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
                            <label for="tipo_veiculo" class="form-label fw-medium">Tipo de Veículo <span class="text-danger">*</span></label>
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
                                    <option value="<?php echo e($tipo); ?>" <?php echo e(old('tipo_veiculo') === $tipo ? 'selected' : ''); ?>>
                                        <?php echo e($tipo); ?>

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

                        
                        <div class="col-md-2">
                            <label for="numero_compartimentos" class="form-label fw-lower">
                                Nº Compart. <span class="text-danger">*</span>
                            </label>
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
                                   value="<?php echo e(old('numero_compartimentos', 1)); ?>"
                                   min="1"
                                   max="99"
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

                    <div class="row g-3 mb-4">
                        
                        <div class="col-md-3">
                            <label for="numero_equipamento" class="form-label fw-medium">Nº do Equipamento</label>
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
                                   value="<?php echo e(old('numero_equipamento')); ?>"
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

                        
                        <div class="col-md-3">
                            <label for="proprietario_id" class="form-label fw-medium">Proprietário</label>
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
                                <option value="">Nenhum (opcional)</option>
                                <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $selected = old('proprietario_id', $requestedClienteId) == $cliente->id ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo e($cliente->id); ?>" <?php echo e($selected); ?>>
                                        <?php echo e($cliente->nome_razao_social); ?> (<?php echo e($cliente->cpf_cnpj); ?>)
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
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> O proprietário pode ser associado depois.
                            </div>
                        </div>
                    </div>

                    
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-2 border-top">
                        <div>
                            <?php if($returnTo === 'relatorios_create' && $returnClienteId): ?>
                                <a href="<?php echo e(route('relatorios.create')); ?>?cliente_id=<?php echo e($returnClienteId); ?>" class="btn btn-outline-secondary rounded-pill">
                                    <i class="bi bi-arrow-left me-1"></i> Voltar ao Relatório
                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-secondary rounded-pill">
                                    <i class="bi bi-arrow-left me-1"></i> Voltar ao Início
                                </a>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-check-lg me-1"></i> Cadastrar Veículo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Programacao\sis_relatorio_php\sis_relatorio_php\resources\views/veiculos/create.blade.php ENDPATH**/ ?>