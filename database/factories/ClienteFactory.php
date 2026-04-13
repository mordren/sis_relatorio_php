<?php

namespace Database\Factories;

use App\Enums\TipoPessoa;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    public function definition(): array
    {
        $tipo = fake()->randomElement(TipoPessoa::cases());

        return [
            'tipo_pessoa' => $tipo->value,
            'nome_razao_social' => $tipo === TipoPessoa::PF ? fake()->name() : fake()->company(),
            'cpf_cnpj' => $tipo === TipoPessoa::PF
                ? fake()->numerify('###########')
                : fake()->numerify('##############'),
            'endereco' => fake()->streetAddress(),
            'cidade' => fake()->city(),
            'estado' => fake()->stateAbbr(),
            'telefone' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'ativo' => true,
        ];
    }

    public function pessoaFisica(): static
    {
        return $this->state(fn () => [
            'tipo_pessoa' => TipoPessoa::PF->value,
            'nome_razao_social' => fake()->name(),
            'cpf_cnpj' => fake()->numerify('###########'),
        ]);
    }

    public function pessoaJuridica(): static
    {
        return $this->state(fn () => [
            'tipo_pessoa' => TipoPessoa::PJ->value,
            'nome_razao_social' => fake()->company(),
            'cpf_cnpj' => fake()->numerify('##############'),
        ]);
    }

    public function inativo(): static
    {
        return $this->state(fn () => ['ativo' => false]);
    }
}
