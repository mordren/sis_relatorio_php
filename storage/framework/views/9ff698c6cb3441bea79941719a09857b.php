

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

<form method="POST" action="<?php echo e(route('relatorios.update', $relatorio)); ?>" id="editForm">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h6 class="mb-0"><i class="bi bi-file-text"></i> Dados do Relatório</h6>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Nº do Relatório</label>
                    <div class="form-control-plaintext fw-bold"><?php echo e($relatorio->numero_relatorio); ?></div>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <div class="form-control-plaintext">
                        <span class="badge <?php echo e($relatorio->status->badgeClass()); ?>"><?php echo e($relatorio->status->label()); ?></span>
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
                    <label for="processo" class="form-label">Processo <span class="text-danger">*</span></label>
                    <select class="form-select <?php $__errorArgs = ['processo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            id="processo" name="processo" required>
                        <?php $__currentLoopData = $processos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($proc->value); ?>"
                                <?php echo e(old('processo', $relatorio->processo->value) === $proc->value ? 'selected' : ''); ?>>
                                <?php echo e($proc->label()); ?>

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
                <div class="col-md-4">
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

                <div class="col-md-4">
                    <label for="lacre_entrada" class="form-label">Lacre Entrada (relatório)</label>
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
                           value="<?php echo e(old('lacre_entrada', $relatorio->lacre_entrada)); ?>">
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

                <div class="col-md-4">
                    <label for="lacre_saida" class="form-label">Lacre Saída (relatório)</label>
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
                           value="<?php echo e(old('lacre_saida', $relatorio->lacre_saida)); ?>">
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
                        <h6 class="mb-0 text-muted"><i class="bi bi-person"></i> Cliente (snapshot — somente leitura)</h6>
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
                        <h6 class="mb-0 text-muted"><i class="bi bi-truck"></i> Veículo (snapshot — somente leitura)</h6>
                    </div>
                    <div class="card-body small">
                        <strong><?php echo e($relatorio->veiculoSnapshot->placa); ?></strong> —
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
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button <?php echo e($ci > 0 ? 'collapsed' : ''); ?>"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#comp-<?php echo e($ci); ?>"
                                    aria-expanded="<?php echo e($ci === 0 ? 'true' : 'false'); ?>">
                                <i class="bi bi-circle me-2"></i>
                                Compartimento
                                <strong class="ms-1">#<?php echo e(old("compartimentos.{$ci}.numero", $comp->numero)); ?></strong>
                                <?php if($comp->produto_anterior_nome): ?>
                                    <span class="ms-2 text-muted small fw-normal">— <?php echo e($comp->produto_anterior_nome); ?></span>
                                <?php endif; ?>
                            </button>
                        </h2>
                        <div id="comp-<?php echo e($ci); ?>"
                             class="accordion-collapse collapse <?php echo e($ci === 0 ? 'show' : ''); ?>"
                             data-bs-parent="#accordionCompartimentos">
                            <div class="accordion-body">
                                
                                <input type="hidden" name="compartimentos[<?php echo e($ci); ?>][id]" value="<?php echo e($comp->id); ?>">

                                
                                <div class="row g-2 mb-3">
                                    <div class="col-sm-2">
                                        <label class="form-label form-label-sm">Nº <span class="text-danger">*</span></label>
                                        <input type="number"
                                               class="form-control form-control-sm <?php $__errorArgs = ["compartimentos.{$ci}.numero"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               name="compartimentos[<?php echo e($ci); ?>][numero]"
                                               value="<?php echo e(old("compartimentos.{$ci}.numero", $comp->numero)); ?>"
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
                                    <div class="col-sm-3">
                                        <label class="form-label form-label-sm">Capacidade (L)</label>
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
                                               step="0.01" min="0.01">
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
                                    <div class="col-sm-4">
                                        <label class="form-label form-label-sm">Produto / Nome</label>
                                        <input type="text"
                                               class="form-control form-control-sm <?php $__errorArgs = ["compartimentos.{$ci}.produto_anterior_nome"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               name="compartimentos[<?php echo e($ci); ?>][produto_anterior_nome]"
                                               value="<?php echo e(old("compartimentos.{$ci}.produto_anterior_nome", $comp->produto_anterior_nome)); ?>"
                                               maxlength="255">
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
                                    <div class="col-sm-2">
                                        <label class="form-label form-label-sm">Nº ONU</label>
                                        <input type="text"
                                               class="form-control form-control-sm <?php $__errorArgs = ["compartimentos.{$ci}.numero_onu"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               name="compartimentos[<?php echo e($ci); ?>][numero_onu]"
                                               value="<?php echo e(old("compartimentos.{$ci}.numero_onu", $comp->numero_onu)); ?>"
                                               maxlength="50">
                                        <?php $__errorArgs = ["compartimentos.{$ci}.numero_onu"];
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
                                    <div class="col-sm-2">
                                        <label class="form-label form-label-sm">Classe de Risco</label>
                                        <input type="text"
                                               class="form-control form-control-sm <?php $__errorArgs = ["compartimentos.{$ci}.classe_risco"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               name="compartimentos[<?php echo e($ci); ?>][classe_risco]"
                                               value="<?php echo e(old("compartimentos.{$ci}.classe_risco", $comp->classe_risco)); ?>"
                                               maxlength="100">
                                        <?php $__errorArgs = ["compartimentos.{$ci}.classe_risco"];
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

                                
                                <div class="row g-2 mb-3">
                                    <div class="col-sm-2">
                                        <label class="form-label form-label-sm">Pressão Vapor</label>
                                        <input type="number"
                                               class="form-control form-control-sm <?php $__errorArgs = ["compartimentos.{$ci}.pressao_vapor"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               name="compartimentos[<?php echo e($ci); ?>][pressao_vapor]"
                                               value="<?php echo e(old("compartimentos.{$ci}.pressao_vapor", $comp->pressao_vapor)); ?>"
                                               step="0.0001" min="0">
                                        <?php $__errorArgs = ["compartimentos.{$ci}.pressao_vapor"];
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
                                    <div class="col-sm-2">
                                        <label class="form-label form-label-sm">Tempo (min)</label>
                                        <input type="number"
                                               class="form-control form-control-sm <?php $__errorArgs = ["compartimentos.{$ci}.tempo_minutos"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               name="compartimentos[<?php echo e($ci); ?>][tempo_minutos]"
                                               value="<?php echo e(old("compartimentos.{$ci}.tempo_minutos", $comp->tempo_minutos)); ?>"
                                               min="0">
                                        <?php $__errorArgs = ["compartimentos.{$ci}.tempo_minutos"];
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
                                    <div class="col-sm-2">
                                        <label class="form-label form-label-sm">Massa Vapor (kg)</label>
                                        <input type="number"
                                               class="form-control form-control-sm <?php $__errorArgs = ["compartimentos.{$ci}.massa_vapor"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               name="compartimentos[<?php echo e($ci); ?>][massa_vapor]"
                                               value="<?php echo e(old("compartimentos.{$ci}.massa_vapor", $comp->massa_vapor)); ?>"
                                               step="0.0001" min="0">
                                        <?php $__errorArgs = ["compartimentos.{$ci}.massa_vapor"];
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
                                    <div class="col-sm-2">
                                        <label class="form-label form-label-sm">Volume Ar (m³)</label>
                                        <input type="number"
                                               class="form-control form-control-sm <?php $__errorArgs = ["compartimentos.{$ci}.volume_ar"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               name="compartimentos[<?php echo e($ci); ?>][volume_ar]"
                                               value="<?php echo e(old("compartimentos.{$ci}.volume_ar", $comp->volume_ar)); ?>"
                                               step="0.0001" min="0">
                                        <?php $__errorArgs = ["compartimentos.{$ci}.volume_ar"];
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
                                    <div class="col-sm-4">
                                        <label class="form-label form-label-sm">Neutralizante</label>
                                        <input type="text"
                                               class="form-control form-control-sm <?php $__errorArgs = ["compartimentos.{$ci}.neutralizante"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               name="compartimentos[<?php echo e($ci); ?>][neutralizante]"
                                               value="<?php echo e(old("compartimentos.{$ci}.neutralizante", $comp->neutralizante)); ?>"
                                               maxlength="255">
                                        <?php $__errorArgs = ["compartimentos.{$ci}.neutralizante"];
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

                                
                                <div class="row g-2">
                                    <div class="col-sm-3">
                                        <label class="form-label form-label-sm">Lacre Entrada</label>
                                        <input type="text"
                                               class="form-control form-control-sm <?php $__errorArgs = ["compartimentos.{$ci}.lacre_entrada_numero"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               name="compartimentos[<?php echo e($ci); ?>][lacre_entrada_numero]"
                                               value="<?php echo e(old("compartimentos.{$ci}.lacre_entrada_numero", $comp->lacre_entrada_numero)); ?>"
                                               maxlength="255">
                                        <?php $__errorArgs = ["compartimentos.{$ci}.lacre_entrada_numero"];
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
                                    <div class="col-sm-3">
                                        <label class="form-label form-label-sm">Lacre Saída</label>
                                        <input type="text"
                                               class="form-control form-control-sm <?php $__errorArgs = ["compartimentos.{$ci}.lacre_saida_numero"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               name="compartimentos[<?php echo e($ci); ?>][lacre_saida_numero]"
                                               value="<?php echo e(old("compartimentos.{$ci}.lacre_saida_numero", $comp->lacre_saida_numero)); ?>"
                                               maxlength="255">
                                        <?php $__errorArgs = ["compartimentos.{$ci}.lacre_saida_numero"];
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\joaor\OneDrive\Documentos\php\descontaminacao\resources\views/relatorios/edit.blade.php ENDPATH**/ ?>