<?php

namespace Database\Factories;

use App\Enums\ProcessoRelatorio;
use App\Enums\StatusRelatorio;
use App\Models\RelatorioDescontaminacao;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RelatorioDescontaminacaoFactory extends Factory
{
    protected $model = RelatorioDescontaminacao::class;

    public function definition(): array
    {
        return [
            'numero_relatorio' => 'REL-' . fake()->unique()->numerify('######'),
            'status' => StatusRelatorio::RASCUNHO,
            'data_servico' => fake()->date(),
            'responsavel_tecnico_id' => User::factory(),
            'processo' => fake()->randomElement(ProcessoRelatorio::cases()),
            'observacoes' => fake()->optional()->sentence(),
            'lacre_entrada' => fake()->optional()->numerify('LAC-####'),
            'lacre_saida' => null,
            'criado_por_id' => User::factory(),
        ];
    }

    public function emitido(): static
    {
        return $this->state(fn () => [
            'status' => StatusRelatorio::EMITIDO,
            'emitido_em' => now(),
        ]);
    }

    public function cancelado(string $motivo = 'Cancelado para teste'): static
    {
        return $this->state(fn () => [
            'status' => StatusRelatorio::CANCELADO,
            'cancelado_em' => now(),
            'motivo_cancelamento' => $motivo,
        ]);
    }
}
