<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\Equipamento;
use App\Models\RelatorioClienteSnapshot;
use App\Models\RelatorioCompartimento;
use App\Models\RelatorioDescontaminacao;
use App\Models\RelatorioEquipamentoUtilizado;
use App\Models\RelatorioFinalidade;
use App\Models\RelatorioVeiculoSnapshot;
use App\Models\Veiculo;
use Illuminate\Support\Facades\DB;

class SnapshotService
{
    /**
     * Create a frozen client snapshot for the given report.
     * Copies all relevant fields from the live Cliente record.
     */
    public function createClienteSnapshot(
        RelatorioDescontaminacao $relatorio,
        Cliente $cliente
    ): RelatorioClienteSnapshot {
        return RelatorioClienteSnapshot::create([
            'relatorio_id' => $relatorio->id,
            'cliente_origem_id' => $cliente->id,
            'tipo_pessoa' => $cliente->tipo_pessoa->value,
            'nome_razao_social' => $cliente->nome_razao_social,
            'cpf_cnpj' => $cliente->cpf_cnpj,
            'endereco' => $cliente->endereco,
            'cidade' => $cliente->cidade,
            'estado' => $cliente->estado,
            'telefone' => $cliente->telefone,
            'email' => $cliente->email,
        ]);
    }

    /**
     * Create a frozen vehicle snapshot for the given report.
     * Copies all relevant fields from the live Veiculo record.
     */
    public function createVeiculoSnapshot(
        RelatorioDescontaminacao $relatorio,
        Veiculo $veiculo
    ): RelatorioVeiculoSnapshot {
        return RelatorioVeiculoSnapshot::create([
            'relatorio_id' => $relatorio->id,
            'veiculo_origem_id' => $veiculo->id,
            'placa' => $veiculo->placa,
            'modelo' => $veiculo->modelo,
            'marca' => $veiculo->marca,
            'ano' => $veiculo->ano,
            'tipo_veiculo' => $veiculo->tipo_veiculo,
        ]);
    }

    /**
     * Create empty compartment snapshot rows based on the vehicle's
     * numero_compartimentos field.
     *
     * Details (product name, UN number, capacity, etc.) are filled later on
     * the report edit page. Rows are numbered sequentially from 1.
     *
     * NOTE: Never reads from VeiculoCompartimento in the active workflow.
     *
     * @return \Illuminate\Support\Collection<int, RelatorioCompartimento>
     */
    public function createCompartimentoSnapshots(
        RelatorioDescontaminacao $relatorio,
        Veiculo $veiculo
    ) {
        $count = max(1, (int) $veiculo->numero_compartimentos);

        return collect(range(1, $count))->map(function (int $numero) use ($relatorio) {
            return RelatorioCompartimento::create([
                'relatorio_id' => $relatorio->id,
                'compartimento_origem_id' => null,
                'numero' => $numero,
                'capacidade_litros' => null,
                'produto_anterior_nome' => null,
            ]);
        });
    }

    /**
     * Create a frozen equipment snapshot for the given report.
     * Captures name and type from the live Equipamento record at this moment.
     */
    public function createEquipamentoSnapshot(
        RelatorioDescontaminacao $relatorio,
        Equipamento $equipamento,
        int $quantidade = 1,
        ?string $numeroSerie = null,
        ?string $observacao = null
    ): RelatorioEquipamentoUtilizado {
        return RelatorioEquipamentoUtilizado::create([
            'relatorio_id' => $relatorio->id,
            'equipamento_origem_id' => $equipamento->id,
            'nome_snapshot' => $equipamento->nome,
            'tipo_snapshot' => $equipamento->tipo->value,
            'quantidade' => $quantidade,
            'numero_serie' => $numeroSerie,
            'observacao' => $observacao,
        ]);
    }

    /**
     * Create the full report aggregate with all snapshots in a single transaction.
     *
     * @param  array  $reportData  Validated report data
     * @param  array  $finalidadesData  Array of finalidade items
     * @param  Cliente  $cliente  Source client for snapshot
     * @param  Veiculo  $veiculo  Source vehicle for snapshot
     * @param  array  $equipamentosData  Array of equipment items with keys: equipamento_id, quantidade, numero_serie, observacao
     */
    public function createFullReport(
        array $reportData,
        array $finalidadesData,
        Cliente $cliente,
        Veiculo $veiculo,
        array $equipamentosData = []
    ): RelatorioDescontaminacao {
        return DB::transaction(function () use ($reportData, $finalidadesData, $cliente, $veiculo, $equipamentosData) {
            // Generate the next report number atomically to prevent race conditions.
            $maxNumber = RelatorioDescontaminacao::lockForUpdate()->max('numero_relatorio') ?? 0;
            $reportData['numero_relatorio'] = (int) $maxNumber + 1;

            $relatorio = RelatorioDescontaminacao::create($reportData);

            $this->createClienteSnapshot($relatorio, $cliente);
            $this->createVeiculoSnapshot($relatorio, $veiculo);
            $this->createCompartimentoSnapshots($relatorio, $veiculo);

            foreach ($finalidadesData as $finalidade) {
                RelatorioFinalidade::create([
                    'relatorio_id' => $relatorio->id,
                    'finalidade' => $finalidade['finalidade'],
                    'descricao_outros' => $finalidade['descricao_outros'] ?? null,
                ]);
            }

            foreach ($equipamentosData as $eqData) {
                $equipamento = Equipamento::findOrFail($eqData['equipamento_id']);
                $this->createEquipamentoSnapshot(
                    $relatorio,
                    $equipamento,
                    $eqData['quantidade'] ?? 1,
                    $eqData['numero_serie'] ?? null,
                    $eqData['observacao'] ?? null,
                );
            }

            return $relatorio->load([
                'clienteSnapshot',
                'veiculoSnapshot',
                'finalidades',
                'compartimentos',
                'equipamentosUtilizados',
            ]);
        });
    }
}
