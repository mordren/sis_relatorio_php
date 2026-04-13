

<?php $__env->startSection('title', 'Cadastrar Veículo'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <?php if($activeClientCount > 0): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i>
                <?php echo e($activeClientCount); ?> <?php echo e($activeClientCount === 1 ? 'cliente ativo disponível' : 'clientes ativos disponíveis'); ?> para associar como proprietário.
            </div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-truck"></i> Cadastrar Veículo</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('veiculos.store')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="placa" class="form-label">Placa <span class="text-danger">*</span></label>
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
                                   style="text-transform: uppercase"
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
                                   value="<?php echo e(old('marca')); ?>"
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
                                   value="<?php echo e(old('modelo')); ?>"
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
                            <label for="ano" class="form-label">Ano</label>
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
                                   max="<?php echo e(date('Y') + 2); ?>">
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
                            <label for="tipo_veiculo" class="form-label">Tipo de Veículo</label>
                            <input type="text"
                                   class="form-control <?php $__errorArgs = ['tipo_veiculo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="tipo_veiculo"
                                   name="tipo_veiculo"
                                   value="<?php echo e(old('tipo_veiculo')); ?>"
                                   placeholder="Ex: Caminhão Tanque">
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
                                <option value="">Nenhum</option>
                                <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($cliente->id); ?>" <?php echo e(old('proprietario_id') == $cliente->id ? 'selected' : ''); ?>>
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
                        </div>
                    </div>

                    
                    <fieldset class="mb-4">
                        <legend class="h6 border-bottom pb-2 mb-3">
                            <i class="bi bi-layout-split"></i> Compartimentos <span class="text-danger">*</span>
                        </legend>

                        <?php $__errorArgs = ['compartimentos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="alert alert-danger py-2"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        <div id="compartimentos-container">
                            <?php
                                $oldCompartimentos = old('compartimentos', [['numero' => 1, 'capacidade_litros' => '', 'produto_atual_id' => '']]);
                            ?>

                            <?php $__currentLoopData = $oldCompartimentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ci => $oldComp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="row mb-2 align-items-start compartimento-row">
                                <div class="col-md-2">
                                    <label class="form-label">Nº <span class="text-danger">*</span></label>
                                    <input type="number"
                                           class="form-control <?php $__errorArgs = ["compartimentos.{$ci}.numero"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           name="compartimentos[<?php echo e($ci); ?>][numero]"
                                           value="<?php echo e($oldComp['numero'] ?? ($ci + 1)); ?>"
                                           min="1" required>
                                    <?php $__errorArgs = ["compartimentos.{$ci}.numero"];
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
                                    <label class="form-label">Capacidade (L) <span class="text-danger">*</span></label>
                                    <input type="number"
                                           class="form-control <?php $__errorArgs = ["compartimentos.{$ci}.capacidade_litros"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           name="compartimentos[<?php echo e($ci); ?>][capacidade_litros]"
                                           value="<?php echo e($oldComp['capacidade_litros'] ?? ''); ?>"
                                           step="0.01" min="0.01" required>
                                    <?php $__errorArgs = ["compartimentos.{$ci}.capacidade_litros"];
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
                                <div class="col-md-5">
                                    <label class="form-label">Produto Atual</label>
                                    <select class="form-select <?php $__errorArgs = ["compartimentos.{$ci}.produto_atual_id"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            name="compartimentos[<?php echo e($ci); ?>][produto_atual_id]">
                                        <option value="">Nenhum / Vazio</option>
                                        <?php $__currentLoopData = $produtos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($produto->id); ?>"
                                                <?php echo e(($oldComp['produto_atual_id'] ?? '') == $produto->id ? 'selected' : ''); ?>>
                                                <?php echo e($produto->nome); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ["compartimentos.{$ci}.produto_atual_id"];
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
                                <div class="col-md-2 d-flex align-items-end pb-1">
                                    <?php if($ci > 0): ?>
                                        <button type="button" class="btn btn-outline-danger btn-sm remove-compartimento">
                                            <i class="bi bi-trash"></i> Remover
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-compartimento">
                            <i class="bi bi-plus"></i> Adicionar Compartimento
                        </button>
                    </fieldset>

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Cadastrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('compartimentos-container');
    const addBtn = document.getElementById('add-compartimento');
    let index = <?php echo e(count($oldCompartimentos)); ?>;

    const produtoOptions = `
        <option value="">Nenhum / Vazio</option>
        <?php $__currentLoopData = $produtos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($produto->id); ?>"><?php echo e($produto->nome); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    `;

    addBtn.addEventListener('click', function () {
        const row = document.createElement('div');
        row.className = 'row mb-2 align-items-start compartimento-row';
        row.innerHTML = `
            <div class="col-md-2">
                <label class="form-label">Nº <span class="text-danger">*</span></label>
                <input type="number" class="form-control"
                       name="compartimentos[${index}][numero]"
                       value="${index + 1}" min="1" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Capacidade (L) <span class="text-danger">*</span></label>
                <input type="number" class="form-control"
                       name="compartimentos[${index}][capacidade_litros]"
                       step="0.01" min="0.01" required>
            </div>
            <div class="col-md-5">
                <label class="form-label">Produto Atual</label>
                <select class="form-select" name="compartimentos[${index}][produto_atual_id]">
                    ${produtoOptions}
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end pb-1">
                <button type="button" class="btn btn-outline-danger btn-sm remove-compartimento">
                    <i class="bi bi-trash"></i> Remover
                </button>
            </div>
        `;
        container.appendChild(row);
        index++;
    });

    container.addEventListener('click', function (e) {
        const btn = e.target.closest('.remove-compartimento');
        if (btn) {
            btn.closest('.compartimento-row').remove();
        }
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\joaor\OneDrive\Documentos\php\descontaminacao\resources\views/veiculos/create.blade.php ENDPATH**/ ?>