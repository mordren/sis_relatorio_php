<?php

namespace Database\Factories;

use App\Models\ProdutoTransportado;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdutoTransportadoFactory extends Factory
{
    protected $model = ProdutoTransportado::class;

    public function definition(): array
    {
        return [
            'nome' => fake()->unique()->words(3, true),
            'classe_risco' => fake()->randomElement(['1', '2', '3', '4.1', '5.1', '6.1', '8', '9']),
            'numero_onu' => fake()->numerify('####'),
            'ativo' => true,
        ];
    }
}
