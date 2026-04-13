<?php

namespace Database\Factories;

use App\Enums\TipoEquipamento;
use App\Models\Equipamento;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipamentoFactory extends Factory
{
    protected $model = Equipamento::class;

    public function definition(): array
    {
        return [
            'nome' => fake()->unique()->words(2, true),
            'tipo' => fake()->randomElement(TipoEquipamento::cases()),
            'descricao' => fake()->sentence(),
            'ativo' => true,
        ];
    }
}
