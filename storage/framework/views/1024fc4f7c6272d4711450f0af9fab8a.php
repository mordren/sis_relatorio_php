

<?php $__env->startSection('title', 'Novo Relatório de Descontaminação'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-8">

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

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
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <div class="text-muted small">
                                        <i class="bi bi-fire text-warning"></i>
                                        <strong>Processo:</strong> Vapor
                                        <span class="badge bg-secondary ms-1">fixo</span>
                                    </div>
                                    <div class="text-muted small">
                                        <i class="bi bi-list-check text-info"></i>
                                        <strong>Finalidade:</strong> Verificação Metrológica
                                        <span class="badge bg-secondary ms-1">fixo</span>
                                    </div>
                                </div>
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
                                        <option value="<?php echo e($cliente->id); ?>">
                                            <?php echo e($cliente->nome_razao_social); ?> ” <?php echo e($cliente->cpf_cnpj); ?>

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
                                    Os dados do cliente serão congelados no momento da criação do Relatório.
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <a href="<?php echo e(route('clientes.create')); ?>" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-plus"></i> Cadastrar Novo Cliente
                                </a>
                            </div>
                        </div>
                    </fieldset>

                    
                    <fieldset class="mb-4">
                        <legend class="h6 border-bottom pb-2 mb-3">
                            <i class="bi bi-truck"></i> Veículo
                        </legend>

                        <?php $__errorArgs = ['veiculo_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="alert alert-danger py-2 mb-2"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="veiculo_id" class="form-label">Selecionar Veículo <span class="text-danger">*</span></label>
                                <select class="form-select"
                                        id="veiculo_id"
                                        name="veiculo_id"
                                        required
                                        disabled>
                                    <option value="">” Selecione um cliente primeiro ”</option>
                                </select>
                                <div class="form-text" id="veiculo-hint">
                                    Selecione um cliente para ver os Veículos disponíveis.
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <a id="add-veiculo-btn"
                                   href="<?php echo e(route('veiculos.create')); ?>"
                                   class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-plus"></i> Novo Veículo
                                </a>
                            </div>
                        </div>
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
                        <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                            <i class="bi bi-check-lg"></i>Imprimir Relatório
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
    const clienteSelect  = document.getElementById('cliente_id');
    const veiculoSelect  = document.getElementById('veiculo_id');
    const addVeiculoBtn  = document.getElementById('add-veiculo-btn');
    const veiculoHint    = document.getElementById('veiculo-hint');
    const submitBtn      = document.getElementById('submitBtn');

    const baseVeiculoUrl = '<?php echo e(route("veiculos.create")); ?>';

    // Read URL params for pre-selection (e.g. returning from vehicle creation)
    const urlParams      = new URLSearchParams(window.location.search);
    const initClienteId  = urlParams.get('cliente_id')   || '<?php echo e(old("cliente_id")); ?>';
    const initVeiculoId  = urlParams.get('new_veiculo_id') || '<?php echo e(old("veiculo_id")); ?>';

    function updateSubmitState() {
        const hasCliente = clienteSelect.value !== '';
        const hasVeiculo = veiculoSelect.value !== '';
        submitBtn.disabled = !(hasCliente && hasVeiculo);
    }

    function loadVeiculos(clienteId, preSelectId) {
        if (!clienteId) {
            veiculoSelect.innerHTML = '<option value="">Selecione um cliente primeiro ”</option>';
            veiculoSelect.disabled  = true;
            addVeiculoBtn.href      = baseVeiculoUrl;
            veiculoHint.textContent = 'Selecione um cliente para ver os Veículos disponíveis.';
            updateSubmitState();
            return;
        }

        veiculoSelect.innerHTML = '<option value="">Carregando...</option>';
        veiculoSelect.disabled  = true;

        const newVeiculoUrl = `${baseVeiculoUrl}?cliente_id=${clienteId}&return_to=relatorios_create&return_cliente_id=${clienteId}`;
        addVeiculoBtn.href  = newVeiculoUrl;

        fetch(`/api/clientes/${clienteId}/veiculos`)
            .then(function (r) { return r.json(); })
            .then(function (veiculos) {
                if (veiculos.length === 0) {
                    veiculoSelect.innerHTML = '<option value="">Nenhum Veículo cadastrado para este cliente</option>';
                    veiculoHint.textContent  = 'Clique em "+ Novo Veículo" para cadastrar um Veículo para este cliente.';
                } else {
                    veiculoSelect.innerHTML  = '<option value="">Selecione um Veículo...</option>';
                    veiculos.forEach(function (v) {
                        const opt     = document.createElement('option');
                        opt.value     = v.id;
                        opt.textContent = v.text + ' (' + v.numero_compartimentos + ' compart.)';
                        if (preSelectId && String(v.id) === String(preSelectId)) {
                            opt.selected = true;
                        }
                        veiculoSelect.appendChild(opt);
                    });
                    veiculoHint.textContent = 'Os dados do Veículo serão congelados no Relatório.';
                }
                veiculoSelect.disabled = false;
                updateSubmitState();
            })
            .catch(function () {
                veiculoSelect.innerHTML = '<option value="">Erro ao carregar Veículos</option>';
                veiculoSelect.disabled  = true;
            });
    }

    clienteSelect.addEventListener('change', function () {
        loadVeiculos(this.value, null);
    });

    veiculoSelect.addEventListener('change', updateSubmitState);

    // Auto-initialize from URL params (e.g. after creating a new vehicle)
    if (initClienteId) {
        clienteSelect.value = initClienteId;
        loadVeiculos(initClienteId, initVeiculoId);
    }
});
</script>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\joaor\OneDrive\Documentos\php\descontaminacao\resources\views/relatorios/create.blade.php ENDPATH**/ ?>