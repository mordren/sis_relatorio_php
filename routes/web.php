<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RelatorioController;
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
    Route::get('/clientes/criar', [ClienteController::class, 'create'])->name('clientes.create');
    Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');

    // Veículos
    Route::get('/veiculos/criar', [VeiculoController::class, 'create'])->name('veiculos.create');
    Route::post('/veiculos', [VeiculoController::class, 'store'])->name('veiculos.store');

    // Relatórios — literal paths first so they are not captured by {relatorio}
    Route::get('/relatorios/criar', [RelatorioController::class, 'create'])->name('relatorios.create');
    Route::post('/relatorios', [RelatorioController::class, 'store'])->name('relatorios.store');
    Route::get('/relatorios/{relatorio}', [RelatorioController::class, 'show'])->name('relatorios.show');
    Route::get('/relatorios/{relatorio}/editar', [RelatorioController::class, 'edit'])->name('relatorios.edit');
    Route::put('/relatorios/{relatorio}', [RelatorioController::class, 'update'])->name('relatorios.update');
});
