

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
                                        <strong>Processo:</strong> Com ventilação forçada
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
                                <label for="cliente_search" class="form-label">Selecionar Cliente <span class="text-danger">*</span></label>
                                <div class="position-relative" id="cliente-autocomplete-wrapper">
                                    <input type="text"
                                           class="form-control <?php $__errorArgs = ['cliente_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="cliente_search"
                                           placeholder="Digite o nome do cliente para buscar..."
                                           autocomplete="off"
                                           value="<?php echo e($oldCliente ? $oldCliente->nome_razao_social . ($oldCliente->cpf_cnpj ? ' — ' . $oldCliente->cpf_cnpj : '') : ''); ?>">
                                    <input type="hidden" id="cliente_id" name="cliente_id"
                                           value="<?php echo e(old('cliente_id', '')); ?>">
                                    <div id="cliente-dropdown"
                                         style="display:none;position:absolute;top:100%;left:0;right:0;z-index:1050;max-height:220px;overflow-y:auto;background:#fff;border:1px solid #dee2e6;border-top:none;border-radius:0 0 .375rem .375rem;box-shadow:0 4px 12px rgba(0,0,0,.1)">
                                    </div>
                                    <?php $__errorArgs = ['cliente_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="form-text">
                                    Os dados do cliente serão congelados no momento da criação do Relatório.
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="button"
                                        class="btn btn-outline-secondary btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalNovoCliente">
                                    <i class="bi bi-person-plus"></i> Cadastrar Novo Cliente
                                </button>
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
                                <button type="button"
                                        id="add-veiculo-btn"
                                        class="btn btn-outline-secondary btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalNovoVeiculo"
                                        disabled>
                                    <i class="bi bi-truck"></i> Novo Veículo
                                </button>
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
                            <i class="bi bi-check-lg"></i>Criar Relatório
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<div class="modal fade" id="modalNovoCliente" tabindex="-1" aria-labelledby="modalNovoClienteLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNovoClienteLabel">
                    <i class="bi bi-person-plus"></i> Cadastrar Novo Cliente
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <form id="formNovoCliente" novalidate>
                <?php echo csrf_field(); ?>
                <div class="modal-body">

                    <div class="alert alert-danger d-none" id="mc-alert" role="alert"></div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="mc_tipo_pessoa" class="form-label">Tipo de Pessoa <span class="text-danger">*</span></label>
                            <select class="form-select" id="mc_tipo_pessoa" name="tipo_pessoa" required>
                                <option value="">Selecione...</option>
                                <option value="PF">Pessoa Física</option>
                                <option value="PJ">Pessoa Jurídica</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-8">
                            <label for="mc_nome_razao_social" class="form-label">Nome / Razão Social <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="mc_nome_razao_social" name="nome_razao_social" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="mc_cpf_cnpj" class="form-label">CPF / CNPJ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="mc_cpf_cnpj" name="cpf_cnpj" maxlength="14" required>
                            <div class="invalid-feedback"></div>
                            <div class="form-text">Somente dígitos. PF: 11 dígitos / PJ: 14 dígitos.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="mc_email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="mc_email" name="email">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="mc_telefone" class="form-label">Telefone</label>
                            <input type="text" class="form-control" id="mc_telefone" name="telefone" maxlength="20">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="mc_endereco" class="form-label">Endereço</label>
                            <input type="text" class="form-control" id="mc_endereco" name="endereco">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label for="mc_cidade" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="mc_cidade" name="cidade">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="mc_estado" class="form-label">Estado (UF)</label>
                            <input type="text" class="form-control" id="mc_estado" name="estado" maxlength="2" placeholder="SP">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" id="mc-submit-btn">
                        <i class="bi bi-check-lg"></i> Cadastrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>

<div class="modal fade" id="modalNovoVeiculo" tabindex="-1" aria-labelledby="modalNovoVeiculoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNovoVeiculoLabel">
                    <i class="bi bi-truck"></i> Cadastrar Novo Veículo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <form id="formNovoVeiculo" novalidate>
                <?php echo csrf_field(); ?>
                
                <input type="hidden" id="mv_proprietario_id" name="proprietario_id">

                <div class="modal-body">
                    <div class="alert alert-danger d-none" id="mv-alert" role="alert"></div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="mv_placa" class="form-label">Placa <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="mv_placa" name="placa"
                                   maxlength="10" style="text-transform:uppercase" placeholder="ABC1D23" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="mv_marca" class="form-label">Marca <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="mv_marca" name="marca"
                                   placeholder="Ex: Volvo" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="mv_modelo" class="form-label">Modelo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="mv_modelo" name="modelo"
                                   placeholder="Ex: FH 540" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="mv_ano" class="form-label">Ano</label>
                            <input type="number" class="form-control" id="mv_ano" name="ano"
                                   min="1900" max="<?php echo e(date('Y') + 2); ?>" placeholder="<?php echo e(date('Y')); ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-5">
                            <label for="mv_tipo_veiculo" class="form-label">Tipo de Veículo <span class="text-danger">*</span></label>
                            <select class="form-select" id="mv_tipo_veiculo" name="tipo_veiculo" required>
                                <option value="">Selecione...</option>
                                <option value="SEMIRREBOQUE">SEMIRREBOQUE</option>
                                <option value="CAMINHAO">CAMINHAO</option>
                                <option value="REBOCADO">REBOCADO</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="mv_numero_compartimentos" class="form-label">Nº Compartimentos <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="mv_numero_compartimentos"
                                   name="numero_compartimentos" min="1" max="99" value="1" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="alert alert-info py-2 mb-0" id="mv-owner-info">
                        <i class="bi bi-info-circle"></i>
                        O veículo será associado ao cliente selecionado no relatório.
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" id="mv-submit-btn">
                        <i class="bi bi-check-lg"></i> Cadastrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const clienteHidden   = document.getElementById('cliente_id');
    const clienteSearch   = document.getElementById('cliente_search');
    const clienteDropdown = document.getElementById('cliente-dropdown');
    const veiculoSelect   = document.getElementById('veiculo_id');
    const addVeiculoBtn   = document.getElementById('add-veiculo-btn');
    const veiculoHint     = document.getElementById('veiculo-hint');
    const submitBtn       = document.getElementById('submitBtn');

    // Read URL params for pre-selection (e.g. returning from vehicle creation)
    const urlParams     = new URLSearchParams(window.location.search);
    const initClienteId = urlParams.get('cliente_id')    || '<?php echo e(old("cliente_id")); ?>';
    const initVeiculoId = urlParams.get('new_veiculo_id') || '<?php echo e(old("veiculo_id")); ?>';

    function updateSubmitState() {
        const hasCliente = clienteHidden.value !== '';
        const hasVeiculo = veiculoSelect.value !== '';
        submitBtn.disabled = !(hasCliente && hasVeiculo);
    }

    function loadVeiculos(clienteId, preSelectId) {
        if (!clienteId) {
            veiculoSelect.innerHTML = '<option value="">Selecione um cliente primeiro ”</option>';
            veiculoSelect.disabled  = true;
            addVeiculoBtn.disabled  = true;
            veiculoHint.textContent = 'Selecione um cliente para ver os Veículos disponíveis.';
            updateSubmitState();
            return;
        }

        veiculoSelect.innerHTML = '<option value="">Carregando...</option>';
        veiculoSelect.disabled  = true;

        addVeiculoBtn.disabled  = false;

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

    // ── Autocomplete: Busca de Clientes ──────────────────────────────────────
    let searchTimer = null;

    function escapeHtml(s) {
        var d = document.createElement('div');
        d.appendChild(document.createTextNode(s));
        return d.innerHTML;
    }

    function setCliente(id, text, nome) {
        clienteHidden.value = id;
        clienteSearch.value = nome || text;
        clienteDropdown.style.display = 'none';
        loadVeiculos(id, null);
        updateSubmitState();
    }

    function showClienteDropdown(items) {
        if (!items.length) {
            clienteDropdown.innerHTML = '<div style="padding:8px 12px;color:#666;font-size:13px">Nenhum cliente encontrado.</div>';
        } else {
            clienteDropdown.innerHTML = items.map(function (c) {
                return '<div class="ac-item" data-id="' + c.id + '" data-nome="' + escapeHtml(c.nome) + '" data-text="' + escapeHtml(c.text) + '" style="padding:8px 12px;cursor:pointer;font-size:13px;border-bottom:1px solid #f0f0f0">' + escapeHtml(c.text) + '</div>';
            }).join('');
            clienteDropdown.querySelectorAll('.ac-item').forEach(function (item) {
                item.addEventListener('mousedown', function (e) {
                    e.preventDefault();
                    setCliente(this.dataset.id, this.dataset.text, this.dataset.nome);
                });
                item.addEventListener('mouseover', function () { this.style.background = '#f0f7ff'; });
                item.addEventListener('mouseout',  function () { this.style.background = ''; });
            });
        }
        clienteDropdown.style.display = 'block';
    }

    clienteSearch.addEventListener('input', function () {
        var q = this.value.trim();
        clearTimeout(searchTimer);
        clienteHidden.value = '';
        loadVeiculos('', null);
        updateSubmitState();
        if (q.length === 0) {
            clienteDropdown.style.display = 'none';
            return;
        }
        searchTimer = setTimeout(function () {
            fetch('/api/clientes/search?q=' + encodeURIComponent(q))
                .then(function (r) { return r.json(); })
                .then(showClienteDropdown)
                .catch(function () {
                    clienteDropdown.innerHTML = '<div style="padding:8px 12px;color:#dc3545">Erro ao buscar clientes.</div>';
                    clienteDropdown.style.display = 'block';
                });
        }, 250);
    });

    clienteSearch.addEventListener('blur', function () {
        setTimeout(function () { clienteDropdown.style.display = 'none'; }, 200);
    });

    document.addEventListener('click', function (e) {
        if (!e.target.closest('#cliente-autocomplete-wrapper')) {
            clienteDropdown.style.display = 'none';
        }
    });

    veiculoSelect.addEventListener('change', updateSubmitState);

    // Auto-initialize from URL params or old() (e.g. after returning from vehicle creation)
    if (initClienteId) {
        clienteHidden.value = initClienteId;
        fetch('/api/clientes/search?id=' + encodeURIComponent(initClienteId))
            .then(function (r) { return r.json(); })
            .then(function (data) { if (data && data[0]) { clienteSearch.value = data[0].nome; } })
            .catch(function () {});
        loadVeiculos(initClienteId, initVeiculoId);
        updateSubmitState();
    }

    // ── Modal: Cadastrar Novo Cliente ────────────────────────────────────────
    const modalEl   = document.getElementById('modalNovoCliente');
    const modalForm = document.getElementById('formNovoCliente');
    const mcAlert   = document.getElementById('mc-alert');
    const mcSubmit  = document.getElementById('mc-submit-btn');

    // Reset form and clear errors when modal opens
    modalEl.addEventListener('show.bs.modal', function () {
        modalForm.reset();
        modalForm.querySelectorAll('.is-invalid').forEach(function (el) {
            el.classList.remove('is-invalid');
        });
        modalForm.querySelectorAll('.invalid-feedback').forEach(function (el) {
            el.textContent = '';
        });
        mcAlert.classList.add('d-none');
        mcAlert.textContent = '';
    });

    modalForm.addEventListener('submit', function (e) {
        e.preventDefault();

        mcSubmit.disabled     = true;
        mcSubmit.innerHTML    = '<span class="spinner-border spinner-border-sm" role="status"></span> Cadastrando...';
        mcAlert.classList.add('d-none');

        // Clear previous field errors
        modalForm.querySelectorAll('.is-invalid').forEach(function (el) {
            el.classList.remove('is-invalid');
        });
        modalForm.querySelectorAll('.invalid-feedback').forEach(function (el) {
            el.textContent = '';
        });

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/clientes', {
            method:  'POST',
            headers: {
                'Accept':       'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: new FormData(modalForm),
        })
        .then(function (response) {
            if (response.status === 201) {
                return response.json().then(function (data) { return { ok: true, data: data }; });
            }
            if (response.status === 422) {
                return response.json().then(function (data) { return { ok: false, errors: data.errors }; });
            }
            return response.json().then(function (data) {
                throw new Error(data.message || 'Erro inesperado ao cadastrar cliente.');
            });
        })
        .then(function (result) {
            if (result.ok) {
                // Set client in autocomplete and trigger vehicle load
                setCliente(result.data.id, result.data.text, result.data.nome || result.data.text);

                // Close modal
                bootstrap.Modal.getInstance(modalEl).hide();
            } else {
                // Show per-field validation errors
                Object.entries(result.errors).forEach(function (entry) {
                    var field   = entry[0];
                    var messages = entry[1];
                    var input   = modalForm.querySelector('[name="' + field + '"]');
                    if (input) {
                        input.classList.add('is-invalid');
                        var fb = input.nextElementSibling;
                        if (fb && fb.classList.contains('invalid-feedback')) {
                            fb.textContent = messages[0];
                        }
                    }
                });
            }
        })
        .catch(function (err) {
            mcAlert.textContent = err.message;
            mcAlert.classList.remove('d-none');
        })
        .finally(function () {
            mcSubmit.disabled  = false;
            mcSubmit.innerHTML = '<i class="bi bi-check-lg"></i> Cadastrar';
        });
    });

    // ── Modal: Cadastrar Novo Veículo ────────────────────────────────────────
    const mvModalEl   = document.getElementById('modalNovoVeiculo');
    const mvForm      = document.getElementById('formNovoVeiculo');
    const mvAlert     = document.getElementById('mv-alert');
    const mvSubmit    = document.getElementById('mv-submit-btn');
    const mvProprietarioInput = document.getElementById('mv_proprietario_id');

    // Pre-fill proprietario_id and reset form when modal opens
    mvModalEl.addEventListener('show.bs.modal', function () {
        mvForm.reset();
        mvForm.querySelectorAll('.is-invalid').forEach(function (el) {
            el.classList.remove('is-invalid');
        });
        mvForm.querySelectorAll('.invalid-feedback').forEach(function (el) {
            el.textContent = '';
        });
        mvAlert.classList.add('d-none');
        mvAlert.textContent = '';
        // Inject the currently-selected client as the vehicle owner
        mvProprietarioInput.value = clienteHidden.value || '';
    });

    mvForm.addEventListener('submit', function (e) {
        e.preventDefault();

        mvSubmit.disabled  = true;
        mvSubmit.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Cadastrando...';
        mvAlert.classList.add('d-none');

        mvForm.querySelectorAll('.is-invalid').forEach(function (el) {
            el.classList.remove('is-invalid');
        });
        mvForm.querySelectorAll('.invalid-feedback').forEach(function (el) {
            el.textContent = '';
        });

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/veiculos', {
            method:  'POST',
            headers: {
                'Accept':       'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: new FormData(mvForm),
        })
        .then(function (response) {
            if (response.status === 201) {
                return response.json().then(function (data) { return { ok: true, data: data }; });
            }
            if (response.status === 422) {
                return response.json().then(function (data) { return { ok: false, errors: data.errors }; });
            }
            return response.json().then(function (data) {
                throw new Error(data.message || 'Erro inesperado ao cadastrar veículo.');
            });
        })
        .then(function (result) {
            if (result.ok) {
                var currentClienteId = clienteHidden.value;
                // Reload the vehicle dropdown for this client, pre-selecting the new vehicle
                loadVeiculos(currentClienteId, result.data.id);
                // Close modal
                bootstrap.Modal.getInstance(mvModalEl).hide();
            } else {
                Object.entries(result.errors).forEach(function (entry) {
                    var field    = entry[0];
                    var messages = entry[1];
                    var input    = mvForm.querySelector('[name="' + field + '"]');
                    if (input) {
                        input.classList.add('is-invalid');
                        var fb = input.nextElementSibling;
                        if (fb && fb.classList.contains('invalid-feedback')) {
                            fb.textContent = messages[0];
                        }
                    }
                });
            }
        })
        .catch(function (err) {
            mvAlert.textContent = err.message;
            mvAlert.classList.remove('d-none');
        })
        .finally(function () {
            mvSubmit.disabled  = false;
            mvSubmit.innerHTML = '<i class="bi bi-check-lg"></i> Cadastrar';
        });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\joaor\OneDrive\Documentos\php\descontaminacao\resources\views/relatorios/create.blade.php ENDPATH**/ ?>