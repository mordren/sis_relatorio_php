<?php

namespace App\Http\Controllers;

use App\Models\RelatorioDescontaminacao;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $relatorios = RelatorioDescontaminacao::with(['veiculoSnapshot', 'responsavelTecnico'])
            ->latest()
            ->take(10)
            ->get();

        $proximoRelatorio = (int) Setting::get('proximo_numero_relatorio', 0);

        return view('dashboard', compact('relatorios', 'proximoRelatorio'));
    }

    public function setProximoRelatorio(Request $request): RedirectResponse
    {
        $request->validate([
            'proximo_numero' => ['required', 'integer', 'min:1'],
        ]);

        Setting::set('proximo_numero_relatorio', $request->integer('proximo_numero'));

        return redirect()->route('dashboard')
            ->with('success', 'Próximo número de relatório definido como #' . $request->integer('proximo_numero') . '.');
    }
}
