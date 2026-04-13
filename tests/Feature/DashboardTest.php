<?php

namespace Tests\Feature;

use App\Models\RelatorioDescontaminacao;
use App\Models\RelatorioVeiculoSnapshot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_requires_authentication(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    public function test_dashboard_displays_latest_reports(): void
    {
        $user = User::factory()->create();

        $relatorio = RelatorioDescontaminacao::factory()->create([
            'responsavel_tecnico_id' => $user->id,
            'criado_por_id' => $user->id,
        ]);

        RelatorioVeiculoSnapshot::create([
            'relatorio_id' => $relatorio->id,
            'placa' => 'ABC1D23',
            'modelo' => 'FH 540',
            'marca' => 'Volvo',
            'ano' => 2022,
            'tipo_veiculo' => 'Caminhão Tanque',
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertSee($relatorio->numero_relatorio);
        $response->assertSee('ABC1D23');
    }

    public function test_dashboard_shows_empty_state_when_no_reports(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertSee('Nenhum relatório encontrado');
    }

    public function test_dashboard_shows_at_most_10_reports(): void
    {
        $user = User::factory()->create();

        RelatorioDescontaminacao::factory()
            ->count(15)
            ->create([
                'responsavel_tecnico_id' => $user->id,
                'criado_por_id' => $user->id,
            ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        // The view should contain at most 10 report rows
        $this->assertLessThanOrEqual(
            10,
            substr_count($response->getContent(), '<tr>') - 1 // -1 for the header row
        );
    }
}
