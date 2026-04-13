<?php

namespace Tests\Feature;

use App\Enums\TipoEquipamento;
use App\Models\Cliente;
use App\Models\Equipamento;
use App\Models\User;
use App\Models\Veiculo;
use App\Models\VeiculoCompartimento;
use App\Services\SnapshotService;
use App\Models\RelatorioDescontaminacao;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SnapshotServiceTest extends TestCase
{
    use RefreshDatabase;

    private SnapshotService $service;
    private User $user;
    private Cliente $cliente;
    private Veiculo $veiculo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new SnapshotService();
        $this->user = User::factory()->create();
        $this->cliente = Cliente::factory()->pessoaFisica()->create();
        $this->veiculo = Veiculo::factory()->create();
    }

    public function test_create_cliente_snapshot_copies_all_fields(): void
    {
        $relatorio = RelatorioDescontaminacao::factory()->create([
            'responsavel_tecnico_id' => $this->user->id,
        ]);

        $snapshot = $this->service->createClienteSnapshot($relatorio, $this->cliente);

        $this->assertEquals($relatorio->id, $snapshot->relatorio_id);
        $this->assertEquals($this->cliente->id, $snapshot->cliente_origem_id);
        $this->assertEquals($this->cliente->tipo_pessoa->value, $snapshot->tipo_pessoa->value);
        $this->assertEquals($this->cliente->nome_razao_social, $snapshot->nome_razao_social);
        $this->assertEquals($this->cliente->cpf_cnpj, $snapshot->cpf_cnpj);
        $this->assertEquals($this->cliente->endereco, $snapshot->endereco);
        $this->assertEquals($this->cliente->cidade, $snapshot->cidade);
        $this->assertEquals($this->cliente->estado, $snapshot->estado);
        $this->assertEquals($this->cliente->telefone, $snapshot->telefone);
        $this->assertEquals($this->cliente->email, $snapshot->email);
    }

    public function test_create_veiculo_snapshot_copies_all_fields(): void
    {
        $relatorio = RelatorioDescontaminacao::factory()->create([
            'responsavel_tecnico_id' => $this->user->id,
        ]);

        $snapshot = $this->service->createVeiculoSnapshot($relatorio, $this->veiculo);

        $this->assertEquals($relatorio->id, $snapshot->relatorio_id);
        $this->assertEquals($this->veiculo->id, $snapshot->veiculo_origem_id);
        $this->assertEquals($this->veiculo->placa, $snapshot->placa);
        $this->assertEquals($this->veiculo->modelo, $snapshot->modelo);
        $this->assertEquals($this->veiculo->marca, $snapshot->marca);
        $this->assertEquals($this->veiculo->ano, $snapshot->ano);
        $this->assertEquals($this->veiculo->tipo_veiculo, $snapshot->tipo_veiculo);
    }

    public function test_create_compartimento_snapshots(): void
    {
        VeiculoCompartimento::factory()->create([
            'veiculo_id' => $this->veiculo->id,
            'numero' => 1,
            'capacidade_litros' => 20000.50,
        ]);

        VeiculoCompartimento::factory()->create([
            'veiculo_id' => $this->veiculo->id,
            'numero' => 2,
            'capacidade_litros' => 15000.00,
        ]);

        $relatorio = RelatorioDescontaminacao::factory()->create([
            'responsavel_tecnico_id' => $this->user->id,
        ]);

        $snapshots = $this->service->createCompartimentoSnapshots($relatorio, $this->veiculo);

        $this->assertCount(2, $snapshots);
        $this->assertEquals(1, $snapshots[0]->numero);
        $this->assertEquals('20000.50', $snapshots[0]->capacidade_litros);
    }

    public function test_create_equipamento_snapshot(): void
    {
        $equipamento = Equipamento::factory()->create([
            'nome' => 'Bomba Centrífuga XZ',
            'tipo' => TipoEquipamento::BOMBA,
        ]);

        $relatorio = RelatorioDescontaminacao::factory()->create([
            'responsavel_tecnico_id' => $this->user->id,
        ]);

        $snapshot = $this->service->createEquipamentoSnapshot(
            $relatorio,
            $equipamento,
            2,
            'SN-12345',
            'Em bom estado'
        );

        $this->assertEquals($relatorio->id, $snapshot->relatorio_id);
        $this->assertEquals($equipamento->id, $snapshot->equipamento_origem_id);
        $this->assertEquals('Bomba Centrífuga XZ', $snapshot->nome_snapshot);
        $this->assertEquals(TipoEquipamento::BOMBA, $snapshot->tipo_snapshot);
        $this->assertEquals(2, $snapshot->quantidade);
        $this->assertEquals('SN-12345', $snapshot->numero_serie);
    }

    public function test_create_full_report_in_transaction(): void
    {
        VeiculoCompartimento::factory()->create([
            'veiculo_id' => $this->veiculo->id,
            'numero' => 1,
            'capacidade_litros' => 10000,
        ]);

        $reportData = [
            'status' => 'RASCUNHO',
            'data_servico' => '2024-06-15',
            'responsavel_tecnico_id' => $this->user->id,
            'processo' => 'LAVAGEM',
            'criado_por_id' => $this->user->id,
        ];

        $finalidades = [
            ['finalidade' => 'MANUTENCAO'],
            ['finalidade' => 'CERTIFICACAO'],
        ];

        $relatorio = $this->service->createFullReport(
            $reportData,
            $finalidades,
            $this->cliente,
            $this->veiculo,
        );

        $this->assertNotNull($relatorio->id);
        $this->assertIsInt($relatorio->numero_relatorio);
        $this->assertGreaterThanOrEqual(1, $relatorio->numero_relatorio);
        $this->assertNotNull($relatorio->clienteSnapshot);
        $this->assertNotNull($relatorio->veiculoSnapshot);
        $this->assertCount(2, $relatorio->finalidades);
        $this->assertCount(1, $relatorio->compartimentos);
    }

    public function test_snapshot_isolation_from_source_changes(): void
    {
        $originalPlaca = $this->veiculo->placa;

        $relatorio = RelatorioDescontaminacao::factory()->create([
            'responsavel_tecnico_id' => $this->user->id,
        ]);

        $this->service->createVeiculoSnapshot($relatorio, $this->veiculo);

        // Modify live data
        $this->veiculo->update(['placa' => 'CHANGED1']);

        // Snapshot should remain unchanged
        $relatorio->refresh();
        $this->assertEquals($originalPlaca, $relatorio->veiculoSnapshot->placa);
        $this->assertNotEquals('CHANGED1', $relatorio->veiculoSnapshot->placa);
    }
}
