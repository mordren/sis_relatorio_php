<?php

namespace Tests\Feature;

use App\Enums\FinalidadeRelatorio;
use App\Enums\ProcessoRelatorio;
use App\Enums\StatusRelatorio;
use App\Models\Cliente;
use App\Models\ProdutoTransportado;
use App\Models\RelatorioDescontaminacao;
use App\Models\User;
use App\Models\Veiculo;
use App\Models\VeiculoCompartimento;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RelatorioTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Cliente $cliente;
    private Veiculo $veiculo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->cliente = Cliente::factory()->pessoaFisica()->create();
        $this->veiculo = Veiculo::factory()->create();
    }

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'data_servico' => '2024-06-15',
            'responsavel_tecnico_id' => $this->user->id,
            'processo' => ProcessoRelatorio::LAVAGEM->value,
            'cliente_id' => $this->cliente->id,
            'veiculo_id' => $this->veiculo->id,
            'finalidades' => [
                ['finalidade' => FinalidadeRelatorio::MANUTENCAO->value, 'descricao_outros' => ''],
            ],
        ], $overrides);
    }

    public function test_create_page_requires_authentication(): void
    {
        $response = $this->get(route('relatorios.create'));
        $response->assertRedirect('/login');
    }

    public function test_create_page_is_accessible(): void
    {
        $response = $this->actingAs($this->user)->get(route('relatorios.create'));
        $response->assertStatus(200);
        $response->assertSee('Novo Relatório de Descontaminação');
    }

    public function test_can_create_basic_report(): void
    {
        $response = $this->actingAs($this->user)->post(route('relatorios.store'), $this->validPayload());

        $relatorio = RelatorioDescontaminacao::latest('id')->first();
        $response->assertRedirect(route('relatorios.show', $relatorio));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('relatorio_descontaminacoes', [
            'status' => StatusRelatorio::RASCUNHO->value,
            'processo' => ProcessoRelatorio::LAVAGEM->value,
            'criado_por_id' => $this->user->id,
        ]);
    }

    public function test_report_number_is_numeric_and_auto_increments(): void
    {
        $this->actingAs($this->user)->post(route('relatorios.store'), $this->validPayload());
        $first = RelatorioDescontaminacao::latest('id')->first();
        $this->assertEquals(1, $first->numero_relatorio);

        $this->actingAs($this->user)->post(route('relatorios.store'), $this->validPayload());
        $second = RelatorioDescontaminacao::latest('id')->first();
        $this->assertEquals(2, $second->numero_relatorio);
    }

    public function test_report_creates_frozen_client_snapshot(): void
    {
        $this->actingAs($this->user)->post(route('relatorios.store'), $this->validPayload([
            'processo' => ProcessoRelatorio::VAPOR->value,
        ]));

        $relatorio = RelatorioDescontaminacao::latest('id')->first();
        $this->assertNotNull($relatorio);

        $snapshot = $relatorio->clienteSnapshot;
        $this->assertNotNull($snapshot);
        $this->assertEquals($this->cliente->id, $snapshot->cliente_origem_id);
        $this->assertEquals($this->cliente->nome_razao_social, $snapshot->nome_razao_social);
        $this->assertEquals($this->cliente->cpf_cnpj, $snapshot->cpf_cnpj);
        $this->assertEquals($this->cliente->tipo_pessoa->value, $snapshot->tipo_pessoa->value);
    }

    public function test_report_creates_frozen_vehicle_snapshot(): void
    {
        $this->actingAs($this->user)->post(route('relatorios.store'), $this->validPayload([
            'processo' => ProcessoRelatorio::QUIMICO->value,
        ]));

        $relatorio = RelatorioDescontaminacao::latest('id')->first();
        $snapshot = $relatorio->veiculoSnapshot;
        $this->assertNotNull($snapshot);
        $this->assertEquals($this->veiculo->id, $snapshot->veiculo_origem_id);
        $this->assertEquals($this->veiculo->placa, $snapshot->placa);
        $this->assertEquals($this->veiculo->marca, $snapshot->marca);
        $this->assertEquals($this->veiculo->modelo, $snapshot->modelo);
    }

    public function test_report_creates_frozen_compartment_snapshots(): void
    {
        $produto = ProdutoTransportado::factory()->create(['nome' => 'Diesel S500']);

        VeiculoCompartimento::factory()->create([
            'veiculo_id' => $this->veiculo->id,
            'numero' => 1,
            'capacidade_litros' => 15000.00,
            'produto_atual_id' => $produto->id,
        ]);

        VeiculoCompartimento::factory()->create([
            'veiculo_id' => $this->veiculo->id,
            'numero' => 2,
            'capacidade_litros' => 10000.00,
            'produto_atual_id' => null,
        ]);

        $this->actingAs($this->user)->post(route('relatorios.store'), $this->validPayload([
            'finalidades' => [
                ['finalidade' => FinalidadeRelatorio::TROCA_PRODUTO->value, 'descricao_outros' => ''],
            ],
        ]));

        $relatorio = RelatorioDescontaminacao::latest('id')->first();
        $compartimentos = $relatorio->compartimentos()->orderBy('numero')->get();

        $this->assertCount(2, $compartimentos);
        $this->assertEquals(1, $compartimentos[0]->numero);
        $this->assertEquals('15000.00', $compartimentos[0]->capacidade_litros);
        $this->assertEquals('Diesel S500', $compartimentos[0]->produto_anterior_nome);
        $this->assertEquals(2, $compartimentos[1]->numero);
        $this->assertNull($compartimentos[1]->produto_anterior_nome);
    }

    public function test_snapshot_remains_unchanged_after_source_update(): void
    {
        $originalNome = $this->cliente->nome_razao_social;

        $this->actingAs($this->user)->post(route('relatorios.store'), $this->validPayload());

        $this->cliente->update(['nome_razao_social' => 'Nome Totalmente Diferente']);

        $relatorio = RelatorioDescontaminacao::latest('id')->first();
        $this->assertEquals($originalNome, $relatorio->clienteSnapshot->nome_razao_social);
    }

    public function test_report_creates_finalidades(): void
    {
        $this->actingAs($this->user)->post(route('relatorios.store'), $this->validPayload([
            'finalidades' => [
                ['finalidade' => FinalidadeRelatorio::MANUTENCAO->value, 'descricao_outros' => ''],
                ['finalidade' => FinalidadeRelatorio::CERTIFICACAO->value, 'descricao_outros' => ''],
            ],
        ]));

        $relatorio = RelatorioDescontaminacao::latest('id')->first();
        $this->assertCount(2, $relatorio->finalidades);
    }

    public function test_outros_finalidade_requires_description(): void
    {
        $response = $this->actingAs($this->user)->post(route('relatorios.store'), $this->validPayload([
            'finalidades' => [
                ['finalidade' => FinalidadeRelatorio::OUTROS->value, 'descricao_outros' => ''],
            ],
        ]));

        $response->assertSessionHasErrors();
    }

    public function test_duplicate_finalidades_are_rejected(): void
    {
        $response = $this->actingAs($this->user)->post(route('relatorios.store'), $this->validPayload([
            'finalidades' => [
                ['finalidade' => FinalidadeRelatorio::MANUTENCAO->value, 'descricao_outros' => ''],
                ['finalidade' => FinalidadeRelatorio::MANUTENCAO->value, 'descricao_outros' => ''],
            ],
        ]));

        $response->assertSessionHasErrors('finalidades');
    }

    public function test_lacre_entrada_required_when_lacre_saida_filled(): void
    {
        $response = $this->actingAs($this->user)->post(route('relatorios.store'), $this->validPayload([
            'lacre_saida' => 'LAC-OUT-001',
        ]));

        $response->assertSessionHasErrors('lacre_entrada');
    }

    public function test_lacre_saida_with_lacre_entrada_is_valid(): void
    {
        $response = $this->actingAs($this->user)->post(route('relatorios.store'), $this->validPayload([
            'lacre_entrada' => 'LAC-IN-001',
            'lacre_saida' => 'LAC-OUT-001',
        ]));

        $relatorio = RelatorioDescontaminacao::latest('id')->first();
        $response->assertRedirect(route('relatorios.show', $relatorio));
        $response->assertSessionHas('success');

        $this->assertEquals('LAC-IN-001', $relatorio->lacre_entrada);
        $this->assertEquals('LAC-OUT-001', $relatorio->lacre_saida);
    }

    public function test_at_least_one_finalidade_is_required(): void
    {
        $response = $this->actingAs($this->user)->post(route('relatorios.store'), $this->validPayload([
            'finalidades' => [],
        ]));

        $response->assertSessionHasErrors('finalidades');
    }

    // -----------------------------------------------------------------------
    // Helpers for edit/update tests
    // -----------------------------------------------------------------------

    /**
     * Create a report that has at least one frozen compartimento snapshot.
     * Returns the persisted RelatorioDescontaminacao.
     */
    private function createReportWithCompartments(int $compartmentCount = 1): RelatorioDescontaminacao
    {
        for ($n = 1; $n <= $compartmentCount; $n++) {
            VeiculoCompartimento::factory()->create([
                'veiculo_id' => $this->veiculo->id,
                'numero' => $n,
                'capacidade_litros' => 10000,
            ]);
        }

        $this->actingAs($this->user)
            ->post(route('relatorios.store'), $this->validPayload());

        return RelatorioDescontaminacao::latest('id')->first();
    }

    // -----------------------------------------------------------------------
    // Show
    // -----------------------------------------------------------------------

    public function test_show_page_requires_authentication(): void
    {
        $relatorio = $this->createReportWithCompartments();
        $this->app['auth']->forgetGuards();

        $this->get(route('relatorios.show', $relatorio))
            ->assertRedirect('/login');
    }

    public function test_show_page_displays_report(): void
    {
        $relatorio = $this->createReportWithCompartments();

        $this->actingAs($this->user)
            ->get(route('relatorios.show', $relatorio))
            ->assertStatus(200)
            ->assertSee((string) $relatorio->numero_relatorio)
            ->assertSee($relatorio->processo->label());
    }

    // -----------------------------------------------------------------------
    // Edit
    // -----------------------------------------------------------------------

    public function test_edit_page_requires_authentication(): void
    {
        $relatorio = $this->createReportWithCompartments();
        $this->app['auth']->forgetGuards();

        $this->get(route('relatorios.edit', $relatorio))
            ->assertRedirect('/login');
    }

    public function test_edit_page_loads_for_authenticated_user(): void
    {
        $relatorio = $this->createReportWithCompartments();

        $this->actingAs($this->user)
            ->get(route('relatorios.edit', $relatorio))
            ->assertStatus(200)
            ->assertSee((string) $relatorio->numero_relatorio);
    }

    // -----------------------------------------------------------------------
    // Update
    // -----------------------------------------------------------------------

    public function test_can_update_report_compartments(): void
    {
        $relatorio = $this->createReportWithCompartments();
        $comp = $relatorio->compartimentos()->first();

        $response = $this->actingAs($this->user)->put(route('relatorios.update', $relatorio), [
            'data_servico' => '2024-07-01',
            'responsavel_tecnico_id' => $this->user->id,
            'processo' => ProcessoRelatorio::VAPOR->value,
            'compartimentos' => [
                [
                    'id' => $comp->id,
                    'numero' => $comp->numero,
                    'capacidade_litros' => 12500,
                    'produto_anterior_nome' => 'Diesel S500',
                    'lacre_entrada_numero' => 'LAC-ENT-001',
                    'lacre_saida_numero' => 'LAC-SAI-001',
                    'observacao' => 'Limpo e vistoriado',
                ],
            ],
        ]);

        $response->assertRedirect(route('relatorios.show', $relatorio));
        $response->assertSessionHas('success');

        $comp->refresh();
        $this->assertEquals('12500.00', $comp->capacidade_litros);
        $this->assertEquals('Diesel S500', $comp->produto_anterior_nome);
        $this->assertEquals('LAC-ENT-001', $comp->lacre_entrada_numero);
        $this->assertEquals('LAC-SAI-001', $comp->lacre_saida_numero);
        $this->assertEquals('Limpo e vistoriado', $comp->observacao);

        // Report-level fields also updated
        $relatorio->refresh();
        $this->assertEquals('2024-07-01', $relatorio->data_servico->format('Y-m-d'));
        $this->assertEquals(ProcessoRelatorio::VAPOR, $relatorio->processo);
    }

    public function test_duplicate_compartment_numbers_are_rejected_on_update(): void
    {
        $relatorio = $this->createReportWithCompartments(2);
        $comps = $relatorio->compartimentos()->orderBy('numero')->get();

        $response = $this->actingAs($this->user)->put(route('relatorios.update', $relatorio), [
            'data_servico' => '2024-07-01',
            'responsavel_tecnico_id' => $this->user->id,
            'processo' => ProcessoRelatorio::LAVAGEM->value,
            'compartimentos' => [
                [
                    'id' => $comps[0]->id,
                    'numero' => 1,
                    'capacidade_litros' => 10000,
                ],
                [
                    'id' => $comps[1]->id,
                    'numero' => 1, // duplicate
                    'capacidade_litros' => 10000,
                ],
            ],
        ]);

        $response->assertSessionHasErrors('compartimentos');
    }

    public function test_update_does_not_modify_live_vehicle_compartments(): void
    {
        $relatorio = $this->createReportWithCompartments();
        $liveComp = $this->veiculo->compartimentos()->first();
        $originalCapacidade = $liveComp->capacidade_litros;

        $snapshotComp = $relatorio->compartimentos()->first();

        $this->actingAs($this->user)->put(route('relatorios.update', $relatorio), [
            'data_servico' => '2024-07-01',
            'responsavel_tecnico_id' => $this->user->id,
            'processo' => ProcessoRelatorio::LAVAGEM->value,
            'compartimentos' => [
                [
                    'id' => $snapshotComp->id,
                    'numero' => $snapshotComp->numero,
                    'capacidade_litros' => 99999,
                    'produto_anterior_nome' => 'Alterado',
                ],
            ],
        ]);

        // Report snapshot was updated
        $snapshotComp->refresh();
        $this->assertEquals('99999.00', $snapshotComp->capacidade_litros);

        // Live vehicle compartment is unchanged
        $liveComp->refresh();
        $this->assertEquals($originalCapacidade, $liveComp->capacidade_litros);
    }

    public function test_compartimento_from_another_report_is_rejected(): void
    {
        $relatorio1 = $this->createReportWithCompartments();

        // Create a second report with a separate vehicle so there's no unique constraint conflict.
        $veiculo2 = Veiculo::factory()->create();
        VeiculoCompartimento::factory()->create([
            'veiculo_id' => $veiculo2->id,
            'numero' => 1,
            'capacidade_litros' => 10000,
        ]);
        $this->actingAs($this->user)->post(route('relatorios.store'), array_merge($this->validPayload(), [
            'veiculo_id' => $veiculo2->id,
        ]));
        $relatorio2 = RelatorioDescontaminacao::latest('id')->first();

        $otherComp = $relatorio2->compartimentos()->first();

        $response = $this->actingAs($this->user)->put(route('relatorios.update', $relatorio1), [
            'data_servico' => '2024-07-01',
            'responsavel_tecnico_id' => $this->user->id,
            'processo' => ProcessoRelatorio::LAVAGEM->value,
            'compartimentos' => [
                [
                    'id' => $otherComp->id, // belongs to relatorio2, not relatorio1
                    'numero' => 1,
                    'capacidade_litros' => 10000,
                ],
            ],
        ]);

        $response->assertSessionHasErrors('compartimentos.0.id');
    }

    public function test_lacre_saida_requires_lacre_entrada_on_compartimento(): void
    {
        $relatorio = $this->createReportWithCompartments();
        $comp = $relatorio->compartimentos()->first();

        $response = $this->actingAs($this->user)->put(route('relatorios.update', $relatorio), [
            'data_servico' => '2024-07-01',
            'responsavel_tecnico_id' => $this->user->id,
            'processo' => ProcessoRelatorio::LAVAGEM->value,
            'compartimentos' => [
                [
                    'id' => $comp->id,
                    'numero' => $comp->numero,
                    'capacidade_litros' => 10000,
                    'lacre_entrada_numero' => '',    // missing
                    'lacre_saida_numero' => 'LAC-SAI-999',
                ],
            ],
        ]);

        $response->assertSessionHasErrors('compartimentos.0.lacre_entrada_numero');
    }
}