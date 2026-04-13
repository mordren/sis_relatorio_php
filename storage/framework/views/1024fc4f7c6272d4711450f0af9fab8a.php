

<?php $__env->startSection('title', 'Novo Relatório de Descontaminação'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-file-earmark-plus"></i> Novo Relatório de Descontaminação
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('relatorios.store')); ?>" id="relatorioForm">
                    <?php echo csrf_field(); ?>

                    
                    <fieldset class="mb-4">
                        <legend class="h6 border-bottom pb-2 mb-3">
                            <i class="bi bi-file-text"></i> Dados do Relatório
                        </legend>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Nº do Relatório</label>
                                <div class="form-control-plaintext text-muted fst-italic">
                                    <i class="bi bi-hash"></i> Gerado automaticamente ao salvar
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="data_servico" class="form-label">Data do Serviço <span class="text-danger">*</span></label>
                                <input type="date"
                                       class="form-control <?php $__errorArgs = ['data_servico'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="data_servico"
                                       name="data_servico"
                                       value="<?php echo e(old('data_servico', date('Y-m-d'))); ?>"
                                       required>
                                <?php $__errorArgs = ['data_servico'];
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
                                <label for="processo" class="form-label">Processo <span class="text-danger">*</span></label>
                                <select class="form-select <?php $__errorArgs = ['processo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="processo"
                                        name="processo"
                                        required>
                                    <option value="">Selecione...</option>
                                    <?php $__currentLoopData = $processos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $processo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($processo->value); ?>" <?php echo e(old('processo') === $processo->value ? 'selected' : ''); ?>>
                                            <?php echo e($processo->label()); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['processo'];
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
                            <div class="col-md-6">
                                <label for="responsavel_tecnico_id" class="form-label">Responsável Técnico <span class="text-danger">*</span></label>
                                <select class="form-select <?php $__errorArgs = ['responsavel_tecnico_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="responsavel_tecnico_id"
                                        name="responsavel_tecnico_id"
                                        required>
                                    <option value="">Selecione...</option>
                                    <?php $__currentLoopData = $responsaveis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($resp->id); ?>" <?php echo e(old('responsavel_tecnico_id') == $resp->id ? 'selected' : ''); ?>>
                                            <?php echo e($resp->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['responsavel_tecnico_id'];
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
                                <label for="lacre_entrada" class="form-label">Lacre de Entrada</label>
                                <input type="text"
                                       class="form-control <?php $__errorArgs = ['lacre_entrada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="lacre_entrada"
                                       name="lacre_entrada"
                                       value="<?php echo e(old('lacre_entrada')); ?>">
                                <?php $__errorArgs = ['lacre_entrada'];
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
                                <label for="lacre_saida" class="form-label">Lacre de Saída</label>
                                <input type="text"
                                       class="form-control <?php $__errorArgs = ['lacre_saida'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="lacre_saida"
                                       name="lacre_saida"
                                       value="<?php echo e(old('lacre_saida')); ?>">
                                <?php $__errorArgs = ['lacre_saida'];
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
                    </fieldset>

                    
                    <fieldset class="mb-4">
                        <legend class="h6 border-bottom pb-2 mb-3">
                            <i class="bi bi-person"></i> Cliente
                        </legend>

                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="cliente_id" class="form-label">Selecionar Cliente <span class="text-danger">*</span></label>
                                <select class="form-select <?php $__errorArgs = ['cliente_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="cliente_id"
                                        name="cliente_id"
                                        required>
                                    <option value="">Selecione um cliente...</option>
                                    <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($cliente->id); ?>" <?php echo e(old('cliente_id') == $cliente->id ? 'selected' : ''); ?>>
                                            <?php echo e($cliente->nome_razao_social); ?> - <?php echo e($cliente->cpf_cnpj); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['cliente_id'];
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
                                    Os dados do cliente serão congelados no momento da criação do relatório.
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <a href="<?php echo e(route('clientes.create')); ?>" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-plus"></i> Cadastrar Novo
                                </a>
                            </div>
                        </div>
                    </fieldset>

                    
                    <fieldset class="mb-4">
                        <legend class="h6 border-bottom pb-2 mb-3">
                            <i class="bi bi-truck"></i> Veículo
                        </legend>

                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="veiculo_id" class="form-label">Selecionar Veículo <span class="text-danger">*</span></label>
                                <select class="form-select <?php $__errorArgs = ['veiculo_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="veiculo_id"
                                        name="veiculo_id"
                                        required>
                                    <option value="">Selecione um veículo...</option>
                                    <?php $__currentLoopData = $veiculos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $veiculo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($veiculo->id); ?>" <?php echo e(old('veiculo_id') == $veiculo->id ? 'selected' : ''); ?>>
                                            <?php echo e($veiculo->placa); ?> - <?php echo e($veiculo->marca); ?> <?php echo e($veiculo->modelo); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['veiculo_id'];
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
                                    Os dados do veículo e seus compartimentos serão congelados no momento da criação do relatório.
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <a href="<?php echo e(route('veiculos.create')); ?>" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-plus"></i> Cadastrar Novo
                                </a>
                            </div>
                        </div>
                    </fieldset>

                    
                    <fieldset class="mb-4">
                        <legend class="h6 border-bottom pb-2 mb-3">
                            <i class="bi bi-list-check"></i> Finalidades <span class="text-danger">*</span>
                        </legend>

                        <?php $__errorArgs = ['finalidades'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="alert alert-danger py-2"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        <div id="finalidades-container">
                            <?php
                                $oldFinalidades = old('finalidades', [['finalidade' => '', 'descricao_outros' => '']]);
                            ?>

                            <?php $__currentLoopData = $oldFinalidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $oldFin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="row mb-2 finalidade-row">
                                <div class="col-md-4">
                                    <select class="form-select <?php $__errorArgs = ["finalidades.{$index}.finalidade"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            name="finalidades[<?php echo e($index); ?>][finalidade]"
                                            required>
                                        <option value="">Selecione...</option>
                                        <?php $__currentLoopData = $finalidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($fin->value); ?>"
                                                <?php echo e(($oldFin['finalidade'] ?? '') === $fin->value ? 'selected' : ''); ?>>
                                                <?php echo e($fin->label()); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ["finalidades.{$index}.finalidade"];
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
                                    <input type="text"
                                           class="form-control <?php $__errorArgs = ["finalidades.{$index}.descricao_outros"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           name="finalidades[<?php echo e($index); ?>][descricao_outros]"
                                           value="<?php echo e($oldFin['descricao_outros'] ?? ''); ?>"
                                           placeholder="Descrição (se Outros)">
                                    <?php $__errorArgs = ["finalidades.{$index}.descricao_outros"];
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
                                    <?php if($index > 0): ?>
                                        <button type="button" class="btn btn-outline-danger btn-sm remove-finalidade">
                                            <i class="bi bi-trash"></i> Remover
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-finalidade">
                            <i class="bi bi-plus"></i> Adicionar Finalidade
                        </button>
                    </fieldset>

                    
                    <fieldset class="mb-4">
                        <legend class="h6 border-bottom pb-2 mb-3">
                            <i class="bi bi-chat-left-text"></i> Observações
                        </legend>

                        <div class="mb-3">
                            <textarea class="form-control <?php $__errorArgs = ['observacoes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      id="observacoes"
                                      name="observacoes"
                                      rows="3"
                                      maxlength="5000"><?php echo e(old('observacoes')); ?></textarea>
                            <?php $__errorArgs = ['observacoes'];
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
                    </fieldset>

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Criar Relatório (Rascunho)
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
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('finalidades-container');
    const addBtn = document.getElementById('add-finalidade');
    let index = <?php echo e(count($oldFinalidades)); ?>;

    const finalidadeOptions = `
        <option value="">Selecione...</option>
        <?php $__currentLoopData = $finalidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($fin->value); ?>"><?php echo e($fin->label()); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    `;

    addBtn.addEventListener('click', function() {
        const row = document.createElement('div');
        row.className = 'row mb-2 finalidade-row';
        row.innerHTML = `
            <div class="col-md-4">
                <select class="form-select" name="finalidades[${index}][finalidade]" required>
                    ${finalidadeOptions}
                </select>
            </div>
            <div class="col-md-5">
                <input type="text" class="form-control"
                       name="finalidades[${index}][descricao_outros]"
                       placeholder="Descrição (se Outros)">
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-outline-danger btn-sm remove-finalidade">
                    <i class="bi bi-trash"></i> Remover
                </button>
            </div>
        `;
        container.appendChild(row);
        index++;
    });

    container.addEventListener('click', function(e) {
        const btn = e.target.closest('.remove-finalidade');
        if (btn) {
            btn.closest('.finalidade-row').remove();
        }
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\joaor\OneDrive\Documentos\php\descontaminacao\resources\views/relatorios/create.blade.php ENDPATH**/ ?>