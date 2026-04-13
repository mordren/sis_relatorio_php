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
        $response = $this->actingAs($this->user)->post(route('relatorios.store'), [
            'numero_relatorio' => 'REL-000001',
            'data_servico' => '2024-06-15',
            'responsavel_tecnico_id' => $this->user->id,
            'processo' => ProcessoRelatorio::LAVAGEM->value,
            'cliente_id' => $this->cliente->id,
            'veiculo_id' => $this->veiculo->id,
            'finalidades' => [
                ['finalidade' => FinalidadeRelatorio::MANUTENCAO->value, 'descricao_outros' => ''],
            ],
        ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('relatorio_descontaminacoes', [
            'numero_relatorio' => 'REL-000001',
            'status' => StatusRelatorio::RASCUNHO->value,
            'processo' => ProcessoRelatorio::LAVAGEM->value,
            'criado_por_id' => $this->user->id,
        ]);
    }

    public function test_report_creates_frozen_client_snapshot(): void
    {
        $this->actingAs($this->user)->post(route('relatorios.store'), [
            'numero_relatorio' => 'REL-000002',
            'data_servico' => '2024-06-15',
            'responsavel_tecnico_id' => $this->user->id,
            'processo' => ProcessoRelatorio::VAPOR->value,
            'cliente_id' => $this->cliente->id,
            'veiculo_id' => $this->veiculo->id,
            'finalidades' => [
                ['finalidade' => FinalidadeRelatorio::INSPECAO->value, 'descricao_outros' => ''],
            ],
        ]);

        $relatorio = RelatorioDescontaminacao::where('numero_relatorio', 'REL-000002')->first();
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
        $this->actingAs($this->user)->post(route('relatorios.store'), [
            'numero_relatorio' => 'REL-000003',
            'data_servico' => '2024-06-15',
            'responsavel_tecnico_id' => $this->user->id,
            'processo' => ProcessoRelatorio::QUIMICO->value,
            'cliente_id' => $this->cliente->id,
            'veiculo_id' => $this->veiculo->id,
            'finalidades' => [
                ['finalidade' => FinalidadeRelatorio::CERTIFICACAO->value, 'descricao_outros' => ''],
            ],
        ]);

        $relatorio = RelatorioDescontaminacao::where('numero_relatorio', 'REL-000003')->first();
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

        $this->actingAs($this->user)->post(route('relatorios.store'), [
            'numero_relatorio' => 'REL-000004',
            'data_servico' => '2024-06-15',
            'responsavel_tecnico_id' => $this->user->id,
            'processo' => ProcessoRelatorio::LAVAGEM->value,
            'cliente_id' => $this->cliente->id,
            'veiculo_id' => $this->veiculo->id,
            'finalidades' => [
                ['finalidade' => FinalidadeRelatorio::TROCA_PRODUTO->value, 'descricao_outros' => ''],
            ],
        ]);

        $relatorio = RelatorioDescontaminacao::where('numero_relatorio', 'REL-000004')->first();
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

        $this->actingAs($this->user)->post(route('relatorios.store'), [
            'numero_relatorio' => 'REL-000005',
            'data_servico' => '2024-06-15',
            'responsavel_tecnico_id' => $this->user->id,
            'processo' => ProcessoRelatorio::LAVAGEM->value,
            'cliente_id' => $this->cliente->id,
            'veiculo_id' => $this->veiculo->id,
            'finalidades' => [
                ['finalidade' => FinalidadeRelatorio::MANUTENCAO->value, 'descricao_outros' => ''],
            ],
        ]);

        // Update the live client data
        $this->cliente->update(['nome_razao_social' => 'Nome Totalmente Diferente']);

        // Verify the snapshot still has the original value
        $relatorio = RelatorioDescontaminacao::where('numero_relatorio', 'REL-000005')->first();
        $this->assertEquals($originalNome, $relatorio->clienteSnapshot->nome_razao_social);
    }

    public function test_report_creates_finalidades(): void
    {
        $this->actingAs($this->user)->post(route('relatorios.store'), [
            'numero_relatorio' => 'REL-000006',
            'data_servico' => '2024-06-15',
            'responsavel_tecnico_id' => $this->user->id,
            'processo' => ProcessoRelatorio::LAVAGEM->value,
            'cliente_id' => $this->cliente->id,
            'veiculo_id' => $this->veiculo->id,
            'finalidades' => [
                ['finalidade' => FinalidadeRelatorio::MANUTENCAO->value, 'descricao_outros' => ''],
                ['finalidade' => FinalidadeRelatorio::CERTIFICACAO->value, 'descricao_outros' => ''],
            ],
        ]);

        $relatorio = RelatorioDescontaminacao::where('numero_relatorio', 'REL-000006')->first();
        $this->assertCount(2, $relatorio->finalidades);
    }

    public function test_outros_finalidade_requires_description(): void
    {
        $response = $this->actingAs($this->user)->post(route('relatorios.store'), [
            'numero_relatorio' => 'REL-000007',
            'data_servico' => '2024-06-15',
            'responsavel_tecnico_id' => $this->user->id,
            'processo' => ProcessoRelatorio::LAVAGEM->value,
            'cliente_id' => $this->cliente->id,
            'veiculo_id' => $this->veiculo->id,
            'finalidades' => [
                ['finalidade' => FinalidadeRelatorio::OUTROS->value, 'descricao_outros' => ''],
            ],
        ]);

        $response->assertSessionHasErrors();
    }

    public function test_duplicate_finalidades_are_rejected(): void
    {
        $response = $this->actingAs($this->user)->post(route('relatorios.store'), [
            'numero_relatorio' => 'REL-000008',
            'data_servico' => '2024-06-15',
            'responsavel_tecnico_id' => $this->user->id,
            'processo' => ProcessoRelatorio::LAVAGEM->value,
            'cliente_id' => $this->cliente->id,
            'veiculo_id' => $this->veiculo->id,
            'finalidades' => [
                ['finalidade' => FinalidadeRelatorio::MANUTENCAO->value, 'descricao_outros' => ''],
                ['finalidade' => FinalidadeRelatorio::MANUTENCAO->value, 'descricao_outros' => ''],
            ],
        ]);

        $response->assertSessionHasErrors('finalidades');
    }

    public function test_numero_relatorio_must_be_unique(): void
    {
        RelatorioDescontaminacao::factory()->create([
            'numero_relatorio' => 'REL-000001',
            'responsavel_tecnico_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)->post(route('relatorios.store'), [
            'numero_relatorio' => 'REL-000001',
            'data_servico' => '2024-06-15',
            'responsavel_tecnico_id' => $this->user->id,
            'processo' => ProcessoRelatorio::LAVAGEM->value,
            'cliente_id' => $this->cliente->id,
            'veiculo_id' => $this->veiculo->id,
            'finalidades' => [
                ['finalidade' => FinalidadeRelatorio::MANUTENCAO->value, 'descricao_outros' => ''],
            ],
        ]);

        $response->assertSessionHasErrors('numero_relatorio');
    }

    public function test_lacre_entrada_required_when_lacre_saida_filled(): void
    {
        $response = $this->actingAs($this->user)->post(route('relatorios.store'), [
            'numero_relatorio' => 'REL-000009',
            'data_servico' => '2024-06-15',
            'responsavel_tecnico_id' => $this->user->id,
            'processo' => ProcessoRelatorio::LAVAGEM->value,
            'cliente_id' => $this->cliente->id,
            'veiculo_id' => $this->veiculo->id,
            'lacre_saida' => 'LAC-OUT-001',
            'finalidades' => [
                ['finalidade' => FinalidadeRelatorio::MANUTENCAO->value, 'descricao_outros' => ''],
            ],
        ]);

        $response->assertSessionHasErrors('lacre_entrada');
    }

    public function test_lacre_saida_with_lacre_entrada_is_valid(): void
    {
        $response = $this->actingAs($this->user)->post(route('relatorios.store'), [
            'numero_relatorio' => 'REL-000010',
            'data_servico' => '2024-06-15',
            'responsavel_tecnico_id' => $this->user->id,
            'processo' => ProcessoRelatorio::LAVAGEM->value,
            'cliente_id' => $this->cliente->id,
            'veiculo_id' => $this->veiculo->id,
            'lacre_entrada' => 'LAC-IN-001',
            'lacre_saida' => 'LAC-OUT-001',
            'finalidades' => [
                ['finalidade' => FinalidadeRelatorio::MANUTENCAO->value, 'descricao_outros' => ''],
            ],
        ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('success');

        $relatorio = RelatorioDescontaminacao::where('numero_relatorio', 'REL-000010')->first();
        $this->assertEquals('LAC-IN-001', $relatorio->lacre_entrada);
        $this->assertEquals('LAC-OUT-001', $relatorio->lacre_saida);
    }

    public function test_at_least_one_finalidade_is_required(): void
    {
        $response = $this->actingAs($this->user)->post(route('relatorios.store'), [
            'numero_relatorio' => 'REL-000011',
            'data_servico' => '2024-06-15',
            'responsavel_tecnico_id' => $this->user->id,
            'processo' => ProcessoRelatorio::LAVAGEM->value,
            'cliente_id' => $this->cliente->id,
            'veiculo_id' => $this->veiculo->id,
            'finalidades' => [],
        ]);

        $response->assertSessionHasErrors('finalidades');
    }
}
