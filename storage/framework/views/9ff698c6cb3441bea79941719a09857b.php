

<?php $__env->startSection('title', 'Editar Relatório Nº ' . $relatorio->numero_relatorio); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-pencil-square"></i>
        Editar Relatório <strong>#<?php echo e($relatorio->numero_relatorio); ?></strong>
    </h2>
    <a href="<?php echo e(route('relatorios.show', $relatorio)); ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-x-lg"></i> Cancelar
    </a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('relatorios.update', $relatorio)); ?>" id="editForm">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h6 class="mb-0"><i class="bi bi-file-text"></i> Dados do Relatório</h6>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-2">
                    <label class="form-label">Nº Relatório</label>
                    <div class="form-control-plaintext fw-bold"><?php echo e($relatorio->numero_relatorio); ?></div>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <div class="form-control-plaintext">
                        <span class="badge <?php echo e($relatorio->status->badgeClass()); ?>"><?php echo e($relatorio->status->label()); ?></span>
                    </div>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Processo</label>
                    <div class="form-control-plaintext text-muted">
                        <?php echo e($relatorio->processo->label()); ?>

                        <span class="badge bg-secondary ms-1">fixo</span>
                    </div>
                </div>

                <div class="col-md-3">
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
                           value="<?php echo e(old('data_servico', $relatorio->data_servico->format('Y-m-d'))); ?>"
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

                <div class="col-md-3">
                    <label for="responsavel_tecnico_id" class="form-label">Responsável Técnico <span class="text-danger">*</span></label>
                    <select class="form-select <?php $__errorArgs = ['responsavel_tecnico_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            id="responsavel_tecnico_id" name="responsavel_tecnico_id" required>
                        <?php $__currentLoopData = $responsaveis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($resp->id); ?>"
                                <?php echo e(old('responsavel_tecnico_id', $relatorio->responsavel_tecnico_id) == $resp->id ? 'selected' : ''); ?>>
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
            </div>

            <div class="mb-0">
                <label for="observacoes" class="form-label">Observações</label>
                <textarea class="form-control <?php $__errorArgs = ['observacoes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                          id="observacoes" name="observacoes" rows="3"
                          maxlength="5000"><?php echo e(old('observacoes', $relatorio->observacoes)); ?></textarea>
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
        </div>
    </div>

    
    <div class="row g-3 mb-4">
        <?php if($relatorio->clienteSnapshot): ?>
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h6 class="mb-0 text-muted"><i class="bi bi-person"></i> Cliente (snapshot)</h6>
                    </div>
                    <div class="card-body small">
                        <strong><?php echo e($relatorio->clienteSnapshot->nome_razao_social); ?></strong><br>
                        <?php echo e($relatorio->clienteSnapshot->cpf_cnpj); ?>

                        <?php if($relatorio->clienteSnapshot->cidade): ?>
                            <br><?php echo e($relatorio->clienteSnapshot->cidade); ?>/<?php echo e($relatorio->clienteSnapshot->estado); ?>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if($relatorio->veiculoSnapshot): ?>
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h6 class="mb-0 text-muted"><i class="bi bi-truck"></i> Veículo (snapshot)</h6>
                    </div>
                    <div class="card-body small">
                        <strong><?php echo e($relatorio->veiculoSnapshot->placa); ?></strong> ”
                        <?php echo e($relatorio->veiculoSnapshot->marca); ?> <?php echo e($relatorio->veiculoSnapshot->modelo); ?>

                        <?php if($relatorio->veiculoSnapshot->ano): ?>
                            (<?php echo e($relatorio->veiculoSnapshot->ano); ?>)
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white d-flex align-items-center justify-content-between">
            <h6 class="mb-0"><i class="bi bi-layout-split"></i> Compartimentos do Relatório</h6>
            <small class="text-muted"><?php echo e($relatorio->compartimentos->count()); ?> compartimento(s)</small>
        </div>

        <?php $__errorArgs = ['compartimentos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="alert alert-danger rounded-0 mb-0 py-2 px-3"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <?php if($relatorio->compartimentos->isEmpty()): ?>
            <div class="card-body text-muted">Nenhum compartimento neste relatório.</div>
        <?php else: ?>
            <?php $compartimentos = $relatorio->compartimentos->sortBy('numero'); ?>
            <div class="card-body p-0">
                <div class="accordion accordion-flush" id="accordionCompartimentos">
                <?php $__currentLoopData = $compartimentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ci => $comp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="accordion-item" data-comp-idx="<?php echo e($ci); ?>">
                        <h2 class="accordion-header">
                            <button class="accordion-button <?php echo e($ci > 0 ? 'collapsed' : ''); ?>"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#comp-<?php echo e($ci); ?>"
                                    aria-expanded="<?php echo e($ci === 0 ? 'true' : 'false'); ?>">
                                <i class="bi bi-circle me-2"></i>
                                Compartimento <strong class="ms-1">#<?php echo e($comp->numero); ?></strong>
                                <?php if($comp->produto_anterior_nome): ?>
                                    <span class="ms-2 text-muted small fw-normal">” <?php echo e($comp->produto_anterior_nome); ?></span>
                                <?php endif; ?>
                            </button>
                        </h2>
                        <div id="comp-<?php echo e($ci); ?>"
                             class="accordion-collapse collapse <?php echo e($ci === 0 ? 'show' : ''); ?>"
                             data-bs-parent="#accordionCompartimentos">
                            <div class="accordion-body">
                                
                                <input type="hidden" name="compartimentos[<?php echo e($ci); ?>][id]" value="<?php echo e($comp->id); ?>">
                                <input type="hidden" name="compartimentos[<?php echo e($ci); ?>][numero]" value="<?php echo e($comp->numero); ?>">

                                
                                <div class="row g-2 mb-3">
                                    <div class="col-sm-2">
                                        <label class="form-label form-label-sm">Compart. Nº</label>
                                        <div class="form-control-plaintext form-control-sm fw-bold ps-2">
                                            <?php echo e($comp->numero); ?>

                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label form-label-sm">
                                            Volume / Capacidade (L) m³ <i class="bi bi-calculator text-info" title="Usado no cálculo de Tempo e Volume de Ar"></i>
                                        </label>
                                        <input type="number"
                                               class="form-control form-control-sm <?php $__errorArgs = ["compartimentos.{$ci}.capacidade_litros"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               name="compartimentos[<?php echo e($ci); ?>][capacidade_litros]"
                                               value="<?php echo e(old("compartimentos.{$ci}.capacidade_litros", $comp->capacidade_litros)); ?>"
                                               data-field="capacidade_litros"
                                               step="0.01" min="0.01"
                                               placeholder="Ex: 30 = 30.000 litros">
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
                                    <div class="col-sm-6">
                                        <label class="form-label form-label-sm">
                                            Combustível / Produto <i class="bi bi-arrow-right text-info" title="Preenche automaticamente o Nº ONU"></i>
                                        </label>
                                        <select class="form-select form-select-sm <?php $__errorArgs = ["compartimentos.{$ci}.produto_anterior_nome"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="compartimentos[<?php echo e($ci); ?>][produto_anterior_nome]"
                                                data-field="produto_anterior_nome">
                                            
                                            <?php $__currentLoopData = $produtos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($produto->nome); ?>"
                                                        data-onu="<?php echo e($produto->numero_onu); ?>"
                                                        <?php echo e(old("compartimentos.{$ci}.produto_anterior_nome", $comp->produto_anterior_nome) === $produto->nome ? 'selected' : ''); ?>>
                                                    <?php echo e($produto->nome); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ["compartimentos.{$ci}.produto_anterior_nome"];
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

                                
                                <div class="row g-2 mb-2">
                                    <div class="col-sm-2">
                                        <label class="form-label form-label-sm text-muted">Nº ONU</label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-light border-secondary-subtle" data-display="numero_onu">
                                                <?php echo e($comp->numero_onu ?? '”'); ?>

                                            </span>
                                        </div>
                                        <div class="form-text">auto</div>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="form-label form-label-sm text-muted">Tempo (min)</label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-light border-secondary-subtle" style="min-width:60px" data-display="tempo_minutos">
                                                <?php echo e($comp->tempo_minutos ?? '”'); ?>

                                            </span>
                                        </div>
                                        <div class="form-text">calculado</div>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="form-label form-label-sm text-muted">Volume de Ar</label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-light border-secondary-subtle" style="min-width:60px" data-display="volume_ar">
                                                <?php echo e($comp->volume_ar ?? '”'); ?>

                                            </span>
                                        </div>
                                        <div class="form-text">calculado</div>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="form-label form-label-sm text-muted">Classe Risco</label>
                                        <span class="badge bg-warning text-dark fs-6 d-block mt-1">3</span>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="form-label form-label-sm text-muted">Pressão Vapor</label>
                                        <span class="badge bg-secondary fs-6 d-block mt-1">NA</span>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="form-label form-label-sm text-muted">Neutralizante</label>
                                        <span class="badge bg-secondary fs-6 d-block mt-1">NA</span>
                                    </div>
                                </div>

                                
                                <div class="row g-2">
                                    <div class="col-sm-12">
                                        <label class="form-label form-label-sm">Observação</label>
                                        <input type="text"
                                               class="form-control form-control-sm <?php $__errorArgs = ["compartimentos.{$ci}.observacao"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               name="compartimentos[<?php echo e($ci); ?>][observacao]"
                                               value="<?php echo e(old("compartimentos.{$ci}.observacao", $comp->observacao)); ?>"
                                               maxlength="2000">
                                        <?php $__errorArgs = ["compartimentos.{$ci}.observacao"];
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
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="d-flex justify-content-between">
        <a href="<?php echo e(route('relatorios.show', $relatorio)); ?>" class="btn btn-outline-secondary">
            <i class="bi bi-x-lg"></i> Cancelar
        </a>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-lg"></i> Salvar Alterações
        </button>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
/**
 * SRD-compatible compartment auto-fill logic.
 *
 * Business rules applied on the client side (also enforced server-side):
 *   - tempo_minutos  = capacidade_litros * 12
 *   - volume_ar      = capacidade_litros * 168
 *   - numero_onu     = derived from selected product (data-onu attribute)
 *   - classe_risco   = always 3  (static badge)
 *   - pressao_vapor  = always NA (static badge)
 *   - neutralizante  = always NA (static badge)
 */
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('[data-comp-idx]').forEach(function (item) {
        const volumeInput   = item.querySelector('[data-field="capacidade_litros"]');
        const produtoSelect = item.querySelector('[data-field="produto_anterior_nome"]');
        const onuDisplay    = item.querySelector('[data-display="numero_onu"]');
        const tempoDisplay  = item.querySelector('[data-display="tempo_minutos"]');
        const volArDisplay  = item.querySelector('[data-display="volume_ar"]');

        function recalcFromVolume() {
            const vol = parseFloat(volumeInput ? volumeInput.value : '');
            if (!isNaN(vol) && vol > 0) {
                if (tempoDisplay) tempoDisplay.textContent = Math.round(vol * 12);
                if (volArDisplay) volArDisplay.textContent = Math.round(vol * 168);
            } else {
                if (tempoDisplay) tempoDisplay.textContent = '”';
                if (volArDisplay) volArDisplay.textContent = '”';
            }
        }

        function fillFromProduct() {
            if (!produtoSelect) return;
            const selectedOption = produtoSelect.options[produtoSelect.selectedIndex];
            const onu = selectedOption ? (selectedOption.getAttribute('data-onu') || '') : '';
            if (onuDisplay) onuDisplay.textContent = onu || '”';
        }

        if (volumeInput) {
            volumeInput.addEventListener('blur', recalcFromVolume);
            volumeInput.addEventListener('input', recalcFromVolume);
        }

        if (produtoSelect) {
            produtoSelect.addEventListener('change', fillFromProduct);
            // Run on load to reflect current values
            fillFromProduct();
        }

        // Recalc on load if volume is already populated
        if (volumeInput && volumeInput.value) {
            recalcFromVolume();
        }
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\joaor\OneDrive\Documentos\php\descontaminacao\resources\views/relatorios/edit.blade.php ENDPATH**/ ?>