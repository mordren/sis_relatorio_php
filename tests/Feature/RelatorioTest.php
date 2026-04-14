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
use Database\Seeders\ProdutoCatalogSeeder;
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

        $this->seed(ProdutoCatalogSeeder::class);

        $this->user    = User::factory()->create();
        $this->cliente = Cliente::factory()->pessoaFisica()->create();

        // Vehicle must belong to the client (new validation rule)
        $this->veiculo = Veiculo::factory()->create([
            'proprietario_id' => $this->cliente->id,
        ]);
    }

    /** Minimal valid payload for creating a report. */
    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'data_servico'           => '2024-06-15',
            'responsavel_tecnico_id' => $this->user->id,
            'cliente_id'             => $this->cliente->id,
            'veiculo_id'             => $this->veiculo->id,
        ], $overrides);
    }

    // -----------------------------------------------------------------------
    // Page access
    // -----------------------------------------------------------------------

    public function test_create_page_requires_authentication(): void
    {
        $this->get(route('relatorios.create'))
            ->assertRedirect('/login');
    }

    public function test_create_page_is_accessible(): void
    {
        $this->actingAs($this->user)
            ->get(route('relatorios.create'))
            ->assertStatus(200)
            ->assertSee('Novo Relatório de Descontaminação');
    }

    // -----------------------------------------------------------------------
    // Store — happy path
    // -----------------------------------------------------------------------

    public function test_can_create_basic_report(): void
    {
        $response = $this->actingAs($this->user)->post(route('relatorios.store'), $this->validPayload());

        $relatorio = RelatorioDescontaminacao::latest('id')->first();

        // Now redirects to edit to fill compartment details
        $response->assertRedirect(route('relatorios.edit', $relatorio));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('relatorio_descontaminacoes', [
            'status'   => StatusRelatorio::RASCUNHO->value,
            'processo' => ProcessoRelatorio::VAPOR->value,   // always VAPOR
            'criado_por_id' => $this->user->id,
        ]);
    }

    public function test_report_processo_is_always_vapor(): void
    {
        $this->actingAs($this->user)->post(route('relatorios.store'), $this->validPayload());

        $relatorio = RelatorioDescontaminacao::latest('id')->first();
        $this->assertEquals(ProcessoRelatorio::VAPOR, $relatorio->processo);
    }

    public function test_report_always_creates_verificacao_metrologica_finalidade(): void
    {
        $this->actingAs($this->user)->post(route('relatorios.store'), $this->validPayload());

        $relatorio = RelatorioDescontaminacao::latest('id')->first();
        $this->assertCount(1, $relatorio->finalidades);
        $this->assertEquals(
            FinalidadeRelatorio::VERIFICACAO_METROLOGICA,
            $relatorio->finalidades->first()->finalidade
        );
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
        $this->actingAs($this->user)->post(route('relatorios.store'), $this->validPayload());

        $relatorio = RelatorioDescontaminacao::latest('id')->first();
        $snapshot  = $relatorio->clienteSnapshot;
        $this->assertNotNull($snapshot);
        $this->assertEquals($this->cliente->id, $snapshot->cliente_origem_id);
        $this->assertEquals($this->cliente->nome_razao_social, $snapshot->nome_razao_social);
        $this->assertEquals($this->cliente->cpf_cnpj, $snapshot->cpf_cnpj);
        $this->assertEquals($this->cliente->tipo_pessoa->value, $snapshot->tipo_pessoa->value);
    }

    public function test_report_creates_frozen_vehicle_snapshot(): void
    {
        $this->actingAs($this->user)->post(route('relatorios.store'), $this->validPayload());

        $relatorio = RelatorioDescontaminacao::latest('id')->first();
        $snapshot  = $relatorio->veiculoSnapshot;
        $this->assertNotNull($snapshot);
        $this->assertEquals($this->veiculo->id, $snapshot->veiculo_origem_id);
        $this->assertEquals($this->veiculo->placa, $snapshot->placa);
        $this->assertEquals($this->veiculo->marca, $snapshot->marca);
        $this->assertEquals($this->veiculo->modelo, $snapshot->modelo);
    }

    public function test_report_creates_frozen_compartment_snapshots(): void
    {
        $this->veiculo->update(['numero_compartimentos' => 3]);

        $this->actingAs($this->user)->post(route('relatorios.store'), $this->validPayload());

        $relatorio      = RelatorioDescontaminacao::latest('id')->first();
        $compartimentos = $relatorio->compartimentos()->orderBy('numero')->get();

        $this->assertCount(3, $compartimentos);
        $this->assertEquals(1, $compartimentos[0]->numero);
        $this->assertEquals(2, $compartimentos[1]->numero);
        $this->assertEquals(3, $compartimentos[2]->numero);

        // Empty rows until user fills them in the edit screen
        $this->assertNull($compartimentos[0]->capacidade_litros);
        $this->assertNull($compartimentos[0]->produto_anterior_nome);
        $this->assertNull($compartimentos[1]->numero_onu);
    }

    public function test_snapshot_remains_unchanged_after_source_update(): void
    {
        $originalNome = $this->cliente->nome_razao_social;

        $this->actingAs($this->user)->post(route('relatorios.store'), $this->validPayload());

        $this->cliente->update(['nome_razao_social' => 'Nome Totalmente Diferente']);

        $relatorio = RelatorioDescontaminacao::latest('id')->first();
        $this->assertEquals($originalNome, $relatorio->clienteSnapshot->nome_razao_social);
    }

    // -----------------------------------------------------------------------
    // Store — validation
    // -----------------------------------------------------------------------

    public function test_veiculo_must_belong_to_selected_cliente(): void
    {
        $outroCliente = Cliente::factory()->create();
        $veiculoAlheio = Veiculo::factory()->create(['proprietario_id' => $outroCliente->id]);

        $response = $this->actingAs($this->user)->post(route('relatorios.store'), $this->validPayload([
            'veiculo_id' => $veiculoAlheio->id,  // belongs to outroCliente, not $this->cliente
        ]));

        $response->assertSessionHasErrors('veiculo_id');
    }

    public function test_report_requires_data_servico(): void
    {
        $this->actingAs($this->user)
            ->post(route('relatorios.store'), $this->validPayload(['data_servico' => '']))
            ->assertSessionHasErrors('data_servico');
    }

    public function test_report_requires_cliente(): void
    {
        $payload = $this->validPayload();
        unset($payload['cliente_id']);

        $this->actingAs($this->user)
            ->post(route('relatorios.store'), $payload)
            ->assertSessionHasErrors('cliente_id');
    }

    public function test_report_requires_veiculo(): void
    {
        $payload = $this->validPayload();
        unset($payload['veiculo_id']);

        $this->actingAs($this->user)
            ->post(route('relatorios.store'), $payload)
            ->assertSessionHasErrors('veiculo_id');
    }

    // -----------------------------------------------------------------------
    // AJAX: vehicles per client
    // -----------------------------------------------------------------------

    public function test_vehicles_api_returns_vehicles_for_client(): void
    {
        $outroCliente  = Cliente::factory()->create();
        $veiculoProrio = Veiculo::factory()->create(['proprietario_id' => $this->cliente->id, 'placa' => 'OWN1111']);
        $veiculoAlheio = Veiculo::factory()->create(['proprietario_id' => $outroCliente->id,  'placa' => 'OTH2222']);

        $response = $this->actingAs($this->user)
            ->getJson(route('api.clientes.veiculos', $this->cliente));

        $response->assertStatus(200)
            ->assertJsonCount(2)   // $this->veiculo + veiculoProrio
            ->assertJsonFragment(['id' => $veiculoProrio->id])
            ->assertJsonMissing(['id' => $veiculoAlheio->id]);
    }

    public function test_vehicles_api_requires_authentication(): void
    {
        // JSON requests get 401 (not 302 redirect) from the auth middleware
        $this->getJson(route('api.clientes.veiculos', $this->cliente))
            ->assertStatus(401);
    }

    // -----------------------------------------------------------------------
    // Helpers for edit/update tests
    // -----------------------------------------------------------------------

    /**
     * Create a report whose vehicle has the given number of compartments.
     * Vehicle already belongs to $this->cliente (set in setUp).
     */
    private function createReportWithCompartments(int $compartmentCount = 1): RelatorioDescontaminacao
    {
        $this->veiculo->update(['numero_compartimentos' => $compartmentCount]);

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

    /** Base valid update payload bound to a single compartimento. */
    private function updatePayload(RelatorioDescontaminacao $relatorio, array $compOverrides = [], array $reportOverrides = []): array
    {
        $comp = $relatorio->compartimentos()->first();

        return array_merge([
            'data_servico'           => '2024-07-01',
            'responsavel_tecnico_id' => $this->user->id,
            'compartimentos' => [
                array_merge([
                    'id'     => $comp->id,
                    'numero' => $comp->numero,
                ], $compOverrides),
            ],
        ], $reportOverrides);
    }

    public function test_can_update_report_compartments(): void
    {
        $relatorio = $this->createReportWithCompartments();
        $comp      = $relatorio->compartimentos()->first();

        $response = $this->actingAs($this->user)->put(route('relatorios.update', $relatorio), [
            'data_servico'           => '2024-07-01',
            'responsavel_tecnico_id' => $this->user->id,
            'compartimentos' => [
                [
                    'id'                    => $comp->id,
                    'numero'                => $comp->numero,
                    'capacidade_litros'     => 12500,
                    'produto_anterior_nome' => 'DIESEL',
                    'observacao'            => 'Limpo e vistoriado',
                ],
            ],
        ]);

        $response->assertRedirect(route('relatorios.show', $relatorio));
        $response->assertSessionHas('success');

        $comp->refresh();
        $this->assertEquals('12500.00', $comp->capacidade_litros);
        $this->assertEquals('DIESEL', $comp->produto_anterior_nome);
        $this->assertEquals('1202', $comp->numero_onu);          // server-computed
        $this->assertEquals('3', $comp->classe_risco);           // server-computed
        $this->assertNull($comp->pressao_vapor);                 // always NA
        $this->assertNull($comp->massa_vapor);                   // always NA
        $this->assertEquals('NA', $comp->neutralizante);         // always NA
        $this->assertNull($comp->lacre_entrada_numero);          // removed from workflow
        $this->assertNull($comp->lacre_saida_numero);            // removed from workflow
        $this->assertEquals('Limpo e vistoriado', $comp->observacao);

        // Report-level fields updated
        $relatorio->refresh();
        $this->assertEquals('2024-07-01', $relatorio->data_servico->format('Y-m-d'));

        // Processo is fixed; update never changes it
        $this->assertEquals(ProcessoRelatorio::VAPOR, $relatorio->processo);
    }

    public function test_update_auto_computes_srd_fields_from_volume_and_product(): void
    {
        $relatorio = $this->createReportWithCompartments();
        $comp      = $relatorio->compartimentos()->first();

        $this->actingAs($this->user)->put(route('relatorios.update', $relatorio), [
            'data_servico'           => '2024-07-01',
            'responsavel_tecnico_id' => $this->user->id,
            'compartimentos' => [
                [
                    'id'                    => $comp->id,
                    'numero'                => $comp->numero,
                    'capacidade_litros'     => 100,   // use small, clean number
                    'produto_anterior_nome' => 'ETANOL',
                ],
            ],
        ]);

        $comp->refresh();
        $this->assertEquals('1170', $comp->numero_onu);          // ETANOL → 1170
        $this->assertEquals('3', $comp->classe_risco);           // always 3
        $this->assertNull($comp->pressao_vapor);                 // always NA → null in DB
        $this->assertEquals(1200, $comp->tempo_minutos);         // 100 * 12
        $this->assertNull($comp->massa_vapor);                   // always NA → null in DB
        $this->assertEquals('16800.0000', $comp->volume_ar);    // 100 * 168
        $this->assertEquals('NA', $comp->neutralizante);
    }

    public function test_update_with_unknown_product_leaves_onu_null(): void
    {
        $relatorio = $this->createReportWithCompartments();
        $comp      = $relatorio->compartimentos()->first();

        // produto_anterior_nome = null → numero_onu stays null
        $this->actingAs($this->user)->put(route('relatorios.update', $relatorio), [
            'data_servico'           => '2024-07-01',
            'responsavel_tecnico_id' => $this->user->id,
            'compartimentos' => [
                ['id' => $comp->id, 'numero' => $comp->numero, 'capacidade_litros' => 5000],
            ],
        ]);

        $comp->refresh();
        $this->assertNull($comp->numero_onu);
    }

    public function test_compartimento_capacidade_litros_is_optional_on_update(): void
    {
        $relatorio = $this->createReportWithCompartments();
        $comp      = $relatorio->compartimentos()->first();

        $response = $this->actingAs($this->user)->put(route('relatorios.update', $relatorio), [
            'data_servico'           => '2024-07-01',
            'responsavel_tecnico_id' => $this->user->id,
            'compartimentos' => [
                ['id' => $comp->id, 'numero' => $comp->numero],
            ],
        ]);

        $response->assertRedirect(route('relatorios.show', $relatorio));
        $comp->refresh();
        $this->assertNull($comp->capacidade_litros);
        $this->assertNull($comp->tempo_minutos);
        $this->assertNull($comp->volume_ar);
    }

    public function test_produto_anterior_nome_must_be_in_catalog(): void
    {
        $relatorio = $this->createReportWithCompartments();
        $comp      = $relatorio->compartimentos()->first();

        $response = $this->actingAs($this->user)->put(route('relatorios.update', $relatorio), [
            'data_servico'           => '2024-07-01',
            'responsavel_tecnico_id' => $this->user->id,
            'compartimentos' => [
                [
                    'id'                    => $comp->id,
                    'numero'                => $comp->numero,
                    'produto_anterior_nome' => 'PRODUTO_INVALIDO_XYZ',
                ],
            ],
        ]);

        $response->assertSessionHasErrors('compartimentos.0.produto_anterior_nome');
    }

    public function test_duplicate_compartment_numbers_are_rejected_on_update(): void
    {
        $relatorio = $this->createReportWithCompartments(2);
        $comps     = $relatorio->compartimentos()->orderBy('numero')->get();

        $response = $this->actingAs($this->user)->put(route('relatorios.update', $relatorio), [
            'data_servico'           => '2024-07-01',
            'responsavel_tecnico_id' => $this->user->id,
            'compartimentos' => [
                ['id' => $comps[0]->id, 'numero' => 1, 'capacidade_litros' => 10000],
                ['id' => $comps[1]->id, 'numero' => 1, 'capacidade_litros' => 10000], // duplicate
            ],
        ]);

        $response->assertSessionHasErrors('compartimentos');
    }

    public function test_update_does_not_modify_live_vehicle_data(): void
    {
        $this->veiculo->update(['numero_compartimentos' => 2]);
        $relatorio    = $this->createReportWithCompartments(2);
        $snapshotComp = $relatorio->compartimentos()->first();

        $originalNumeroCompartimentos = $this->veiculo->fresh()->numero_compartimentos;

        $this->actingAs($this->user)->put(route('relatorios.update', $relatorio), [
            'data_servico'           => '2024-07-01',
            'responsavel_tecnico_id' => $this->user->id,
            'compartimentos' => $relatorio->compartimentos->map(fn ($c) => [
                'id'               => $c->id,
                'numero'           => $c->numero,
                'capacidade_litros' => 99999,
            ])->values()->toArray(),
        ]);

        // Report snapshot updated
        $snapshotComp->refresh();
        $this->assertEquals('99999.00', $snapshotComp->capacidade_litros);

        // Live vehicle and compartimento table unchanged
        $this->assertEquals($originalNumeroCompartimentos, $this->veiculo->fresh()->numero_compartimentos);
        $this->assertDatabaseCount('veiculo_compartimentos', 0);
    }

    public function test_compartimento_from_another_report_is_rejected(): void
    {
        $relatorio1 = $this->createReportWithCompartments();

        // Second report using a different vehicle also owned by the same client
        $veiculo2 = Veiculo::factory()->create(['proprietario_id' => $this->cliente->id]);
        $this->actingAs($this->user)->post(route('relatorios.store'), $this->validPayload([
            'veiculo_id' => $veiculo2->id,
        ]));
        $relatorio2 = RelatorioDescontaminacao::latest('id')->first();

        $otherComp = $relatorio2->compartimentos()->first();

        $response = $this->actingAs($this->user)->put(route('relatorios.update', $relatorio1), [
            'data_servico'           => '2024-07-01',
            'responsavel_tecnico_id' => $this->user->id,
            'compartimentos' => [
                [
                    'id'     => $otherComp->id, // belongs to relatorio2
                    'numero' => 1,
                    'capacidade_litros' => 10000,
                ],
            ],
        ]);

        $response->assertSessionHasErrors('compartimentos.0.id');
    }
}
