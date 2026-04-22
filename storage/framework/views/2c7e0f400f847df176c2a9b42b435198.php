<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Dashboard'); ?> - <?php echo e(config('app.name', 'Descontaminação')); ?></title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #0f3b5e;
            --primary-light: #1e5a7e;
            --accent: #2a9d8f;
            --bg-sidebar: #0a1e2c;
            --bg-content: #f4f7fb;
            --text-muted: #6c7a8a;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-content);
            overflow-x: hidden;
        }

        /* Layout wrapper */
        .app-wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* ========== SIDEBAR ========== */
        .sidebar {
            width: 280px;
            background: linear-gradient(145deg, #0a1e2c 0%, #0f2a3b 100%);
            color: #e0edf5;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1000;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.08);
            transition: all 0.2s;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 1.8rem 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: 1.5rem;
        }

        .sidebar-header .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            text-decoration: none;
        }

        .sidebar-header .logo i {
            font-size: 2.2rem;
            color: var(--accent);
        }

        .sidebar-header .logo span {
            font-weight: 600;
            font-size: 1.4rem;
            letter-spacing: -0.02em;
        }

        .sidebar-nav {
            flex: 1;
            padding: 0 1rem;
        }

        .sidebar-nav .nav-item {
            margin-bottom: 6px;
        }

        .sidebar-nav .nav-link {
            color: #b4c9da;
            font-weight: 500;
            padding: 0.85rem 1.2rem;
            border-radius: 14px;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: all 0.2s;
        }

        .sidebar-nav .nav-link i {
            font-size: 1.3rem;
            width: 24px;
            color: #6a8ca3;
        }

        .sidebar-nav .nav-link:hover {
            background: rgba(255, 255, 255, 0.06);
            color: white;
        }

        .sidebar-nav .nav-link.active {
            background: var(--primary-light);
            color: white;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .sidebar-nav .nav-link.active i {
            color: white;
        }

        .sidebar-footer {
            padding: 1.5rem 1.5rem 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 0.85rem;
            color: #8aa0b0;
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            flex: 1;
            margin-left: 280px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header superior */
        .top-header {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.02);
            border-bottom: 1px solid #eef2f6;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .page-title {
            font-weight: 650;
            font-size: 1.5rem;
            color: #1e293b;
            margin: 0;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-dropdown .dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #1e293b;
            font-weight: 500;
            padding: 0.4rem 1rem;
            border-radius: 40px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        .user-dropdown .dropdown-toggle i {
            font-size: 1.4rem;
            color: var(--primary);
        }

        .content-container {
            padding: 2rem 2rem 1.5rem;
            flex: 1;
        }

        /* Cards e componentes */
        .card-modern {
            background: white;
            border-radius: 24px;
            border: none;
            box-shadow: 0 12px 28px -8px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-bottom: 1.8rem;
        }

        .table-modern {
            border-radius: 20px;
            overflow: hidden;
        }

        .btn {
            border-radius: 40px;
            padding: 0.6rem 1.6rem;
            font-weight: 500;
        }

        .btn-primary {
            background: var(--primary);
            border: none;
        }

        .btn-primary:hover {
            background: var(--primary-light);
        }

        /* Lista de relatórios redesenhada */
        .relatorio-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.2rem;
            border-bottom: 1px solid #edf2f7;
            transition: background 0.15s;
        }

        .relatorio-item:hover {
            background: #f9fcff;
        }

        .relatorio-icon {
            width: 48px;
            height: 48px;
            background: #e6f0fa;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 16px;
            color: var(--primary);
        }

        /* Footer */
        .app-footer {
            margin-left: 280px;
            background: transparent;
            padding: 1rem 2rem;
            color: #64748b;
            font-size: 0.85rem;
            border-top: 1px solid #eef2f6;
        }

        /* Responsividade (opcional colapso) */
        @media (max-width: 992px) {
            .sidebar {
                width: 90px;
            }
            .sidebar-header .logo span,
            .sidebar-nav .nav-link span,
            .sidebar-footer span {
                display: none;
            }
            .sidebar-nav .nav-link {
                justify-content: center;
                padding: 0.85rem 0;
            }
            .sidebar-nav .nav-link i {
                margin: 0;
                font-size: 1.5rem;
            }
            .main-content, .app-footer {
                margin-left: 90px;
            }
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

<?php if(auth()->guard()->check()): ?>
<div class="app-wrapper">
    
    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="<?php echo e(Route::has('dashboard') ? route('dashboard') : url('/')); ?>" class="logo">
                <i class="bi bi-droplet-half"></i>
                <span>Descontaminação</span>
            </a>
        </div>

        <ul class="sidebar-nav nav flex-column">
            
            <?php if(Route::has('dashboard')): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Route::is('dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('dashboard')); ?>">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <?php endif; ?>

            
            <?php if(Route::has('clientes.index')): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Route::is('clientes.*') ? 'active' : ''); ?>" href="<?php echo e(route('clientes.index')); ?>">
                    <i class="bi bi-people-fill"></i>
                    <span>Clientes</span>
                </a>
            </li>
            <?php elseif(Route::has('clientes.create')): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Route::is('clientes.*') ? 'active' : ''); ?>" href="<?php echo e(route('clientes.create')); ?>">
                    <i class="bi bi-person-plus-fill"></i>
                    <span>Novo Cliente</span>
                </a>
            </li>
            <?php else: ?>
            <li class="nav-item">
                <span class="nav-link disabled">
                    <i class="bi bi-people-fill"></i>
                    <span>Clientes (breve)</span>
                </span>
            </li>
            <?php endif; ?>

            
            <?php if(Route::has('veiculos.index')): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Route::is('veiculos.*') ? 'active' : ''); ?>" href="<?php echo e(route('veiculos.index')); ?>">
                    <i class="bi bi-truck"></i>
                    <span>Veículos</span>
                </a>
            </li>
            <?php elseif(Route::has('veiculos.create')): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Route::is('veiculos.*') ? 'active' : ''); ?>" href="<?php echo e(route('veiculos.create')); ?>">
                    <i class="bi bi-truck"></i>
                    <span>Novo Veículo</span>
                </a>
            </li>
            <?php else: ?>
            <li class="nav-item">
                <span class="nav-link disabled">
                    <i class="bi bi-truck"></i>
                    <span>Veículos (breve)</span>
                </span>
            </li>
            <?php endif; ?>

            
            <?php if(Route::has('relatorios.index')): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Route::is('relatorios.*') ? 'active' : ''); ?>" href="<?php echo e(route('relatorios.index')); ?>">
                    <i class="bi bi-file-earmark-text-fill"></i>
                    <span>Relatórios</span>
                </a>
            </li>
            <?php elseif(Route::has('relatorios.create')): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Route::is('relatorios.*') ? 'active' : ''); ?>" href="<?php echo e(route('relatorios.create')); ?>">
                    <i class="bi bi-file-earmark-plus-fill"></i>
                    <span>Novo Relatório</span>
                </a>
            </li>
            <?php else: ?>
            <li class="nav-item">
                <span class="nav-link disabled">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Relatórios (breve)</span>
                </span>
            </li>
            <?php endif; ?>

            
            <?php if(Auth::user()->is_admin && Route::has('equipamentos_medicao.index')): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Route::is('equipamentos_medicao.*') ? 'active' : ''); ?>" href="<?php echo e(route('equipamentos_medicao.index')); ?>">
                    <i class="bi bi-tools"></i>
                    <span>Equipamentos</span>
                </a>
            </li>
            <?php endif; ?>

            
            <?php if(Auth::user()->is_admin && Route::has('users.index')): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Route::is('users.*') ? 'active' : ''); ?>" href="<?php echo e(route('users.index')); ?>">
                    <i class="bi bi-people-gear"></i>
                    <span>Usuários</span>
                </a>
            </li>
            <?php endif; ?>
        </ul>

        <div class="sidebar-footer">
            <small><i class="bi bi-shield-check"></i> v1.0 · Seguro</small>
        </div>
    </aside>

    
    <div class="main-content">
        <header class="top-header">
            <h1 class="page-title"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h1>
            <div class="header-actions">
                
                <div class="d-none d-md-block">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 rounded-pill ps-3"><i class="bi bi-search"></i></span>
                        <input type="search" class="form-control border-start-0 rounded-pill ps-0" placeholder="Buscar..." style="max-width: 220px;">
                    </div>
                </div>

                
                <div class="dropdown user-dropdown">
                    <a class="dropdown-toggle text-decoration-none" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                        <span><?php echo e(Auth::user()->name ?? 'Usuário'); ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 mt-2">
                        <li>
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="dropdown-item py-2">
                                    <i class="bi bi-box-arrow-right me-2"></i> Sair
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <div class="content-container">
            
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-4 d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill me-3 fs-5"></i>
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show rounded-4 d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-3 fs-5"></i>
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
</div>


<footer class="app-footer">
    <div class="d-flex justify-content-between">
        <span>&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name', 'Descontaminação')); ?>. Todos os direitos reservados.</span>
        <span><i class="bi bi-droplet"></i> Sistema de Descontaminação</span>
    </div>
</footer>

<?php else: ?>
    
    <main class="py-5">
        <div class="container">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Users\joaor\OneDrive\Documentos\php\descontaminacao\resources\views/layouts/app.blade.php ENDPATH**/ ?>