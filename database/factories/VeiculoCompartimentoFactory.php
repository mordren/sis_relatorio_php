<?php

namespace Database\Factories;

use App\Models\Veiculo;
use App\Models\VeiculoCompartimento;
use Illuminate\Database\Eloquent\Factories\Factory;

class VeiculoCompartimentoFactory extends Factory
{
    protected $model = VeiculoCompartimento::class;

    public function definition(): array
    {
        return [
            'veiculo_id' => Veiculo::factory(),
            'numero' => fake()->numberBetween(1, 10),
            'capacidade_litros' => fake()->randomFloat(2, 500, 30000),
            'produto_atual_id' => null,
        ];
    }
}
