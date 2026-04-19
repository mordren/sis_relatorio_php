<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Veiculo;
use Illuminate\Database\Eloquent\Factories\Factory;

class VeiculoFactory extends Factory
{
    protected $model = Veiculo::class;

    public function definition(): array
    {
        return [
            'placa' => strtoupper(fake()->unique()->bothify('???#?##')),
            'modelo' => fake()->word(),
            'marca' => fake()->randomElement(['Volvo', 'Scania', 'Mercedes-Benz', 'DAF', 'Iveco']),
            'ano' => fake()->numberBetween(2000, date('Y')),
            'tipo_veiculo' => fake()->randomElement(['Caminhão Tanque', 'Carreta', 'Bitrem', 'Rodotrem']),
            'numero_equipamento' => fake()->optional()->numerify('EQ-####'),
            'numero_compartimentos' => 1,
            'proprietario_id' => null,
            'ativo' => true,
        ];
    }

    public function comProprietario(?Cliente $cliente = null): static
    {
        return $this->state(fn () => [
            'proprietario_id' => $cliente?->id ?? Cliente::factory(),
        ]);
    }
}
