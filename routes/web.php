<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipamentoMedicaoController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VeiculoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Clientes
    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/clientes/criar', [ClienteController::class, 'create'])->name('clientes.create');
    Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
    Route::get('/clientes/{cliente}/editar', [ClienteController::class, 'edit'])->name('clientes.edit');
    Route::put('/clientes/{cliente}', [ClienteController::class, 'update'])->name('clientes.update');

    // Veiculos
    Route::get('/veiculos', [VeiculoController::class, 'index'])->name('veiculos.index');
    Route::get('/veiculos/criar', [VeiculoController::class, 'create'])->name('veiculos.create');
    Route::post('/veiculos', [VeiculoController::class, 'store'])->name('veiculos.store');
    Route::get('/veiculos/{veiculo}/editar', [VeiculoController::class, 'edit'])->name('veiculos.edit');
    Route::put('/veiculos/{veiculo}', [VeiculoController::class, 'update'])->name('veiculos.update');

    // AJAX: client search (autocomplete) — must be before {cliente}/veiculos to avoid conflict
    Route::get('/api/clientes/search', [RelatorioController::class, 'searchClientes'])->name('api.clientes.search');

    // AJAX: vehicles filtered by client
    Route::get('/api/clientes/{cliente}/veiculos', [RelatorioController::class, 'veiculosParaCliente'])
        ->name('api.clientes.veiculos');

    // Relatorios
    Route::get('/relatorios/criar', [RelatorioController::class, 'create'])->name('relatorios.create');
    Route::post('/relatorios', [RelatorioController::class, 'store'])->name('relatorios.store');
    Route::get('/relatorios/{relatorio}', [RelatorioController::class, 'show'])->name('relatorios.show');
    Route::get('/relatorios/{relatorio}/editar', [RelatorioController::class, 'edit'])->name('relatorios.edit');
    Route::put('/relatorios/{relatorio}', [RelatorioController::class, 'update'])->name('relatorios.update');
    Route::get('/relatorios/{relatorio}/imprimir', [RelatorioController::class, 'print'])->name('relatorios.print');
    Route::delete('/relatorios/{relatorio}', [RelatorioController::class, 'destroy'])->name('relatorios.destroy');

    // Rotas exclusivas para administradores
    Route::middleware('admin')->group(function () {
        // Equipamentos de Medicao
        Route::prefix('equipamentos-medicao')->group(function () {
            Route::get('', [EquipamentoMedicaoController::class, 'index'])->name('equipamentos_medicao.index');
            Route::get('criar', [EquipamentoMedicaoController::class, 'create'])->name('equipamentos_medicao.create');
            Route::post('', [EquipamentoMedicaoController::class, 'store'])->name('equipamentos_medicao.store');
            Route::get('{equipamento}/editar', [EquipamentoMedicaoController::class, 'edit'])->name('equipamentos_medicao.edit');
            Route::put('{equipamento}', [EquipamentoMedicaoController::class, 'update'])->name('equipamentos_medicao.update');
            Route::delete('{equipamento}', [EquipamentoMedicaoController::class, 'destroy'])->name('equipamentos_medicao.destroy');
        });

        // Gerenciamento de Usuarios
        Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
        Route::get('/usuarios/criar', [UserController::class, 'create'])->name('users.create');
        Route::post('/usuarios', [UserController::class, 'store'])->name('users.store');
        Route::get('/usuarios/{user}/editar', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/usuarios/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});
