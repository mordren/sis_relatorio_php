<?php

namespace App\Http\Controllers;

use App\Models\RelatorioDescontaminacao;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $relatorios = RelatorioDescontaminacao::with(['veiculoSnapshot', 'responsavelTecnico'])
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard', compact('relatorios'));
    }
}
