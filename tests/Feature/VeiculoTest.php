<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\User;
use App\Models\Veiculo;
use App\Models\VeiculoCompartimento;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VeiculoTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    private function oneCompartimento(array $overrides = []): array
    {
        return [array_merge(['numero' => 1, 'capacidade_litros' => 10000, 'produto_atual_id' => null], $overrides)];
    }

    public function test_create_page_requires_authentication(): void
    {
        $response = $this->get(route('veiculos.create'));
        $response->assertRedirect('/login');
    }

    public function test_create_page_is_accessible(): void
    {
        $response = $this->actingAs($this->user)->get(route('veiculos.create'));
        $response->assertStatus(200);
        $response->assertSee('Cadastrar');
    }

    public function test_create_page_shows_active_client_count(): void
    {
        Cliente::factory()->count(3)->create(['ativo' => true]);
        Cliente::factory()->create(['ativo' => false]);

        $response = $this->actingAs($this->user)->get(route('veiculos.create'));

        $response->assertStatus(200);
        $response->assertSee('3 clientes ativos');
    }

    public function test_can_create_vehicle(): void
    {
        $response = $this->actingAs($this->user)->post(route('veiculos.store'), [
            'placa' => 'ABC1D23',
            'modelo' => 'FH 540',
            'marca' => 'Volvo',
            'ano' => 2022,
            'tipo_veiculo' => 'Caminhão Tanque',
            'compartimentos' => $this->oneCompartimento(),
        ]);

        $response->assertRedirect(route('veiculos.create'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('veiculos', [
            'placa' => 'ABC1D23',
            'modelo' => 'FH 540',
            'marca' => 'Volvo',
        ]);
    }

    public function test_creates_vehicle_with_compartments(): void
    {
        $response = $this->actingAs($this->user)->post(route('veiculos.store'), [
            'placa' => 'TRK1234',
            'modelo' => 'Axor 2540',
            'marca' => 'Mercedes',
            'compartimentos' => [
                ['numero' => 1, 'capacidade_litros' => 15000, 'produto_atual_id' => null],
                ['numero' => 2, 'capacidade_litros' => 10000, 'produto_atual_id' => null],
                ['numero' => 3, 'capacidade_litros' => 8000,  'produto_atual_id' => null],
            ],
        ]);

        $response->assertRedirect(route('veiculos.create'));

        $veiculo = Veiculo::where('placa', 'TRK1234')->first();
        $this->assertNotNull($veiculo);

        $compartimentos = $veiculo->compartimentos()->orderBy('numero')->get();
        $this->assertCount(3, $compartimentos);
        $this->assertEquals(1, $compartimentos[0]->numero);
        $this->assertEquals('15000.00', $compartimentos[0]->capacidade_litros);
        $this->assertEquals(2, $compartimentos[1]->numero);
        $this->assertEquals(3, $compartimentos[2]->numero);
    }

    public function test_can_create_vehicle_with_owner(): void
    {
        $cliente = Cliente::factory()->create();

        $response = $this->actingAs($this->user)->post(route('veiculos.store'), [
            'placa' => 'XYZ9W88',
            'modelo' => 'R 450',
            'marca' => 'Scania',
            'proprietario_id' => $cliente->id,
            'compartimentos' => $this->oneCompartimento(),
        ]);

        $response->assertRedirect(route('veiculos.create'));

        $veiculo = Veiculo::where('placa', 'XYZ9W88')->first();
        $this->assertNotNull($veiculo);
        $this->assertEquals($cliente->id, $veiculo->proprietario_id);
    }

    public function test_vehicle_creation_requires_at_least_one_compartment(): void
    {
        $response = $this->actingAs($this->user)->post(route('veiculos.store'), [
            'placa' => 'ABC1D23',
            'modelo' => 'FH 540',
            'marca' => 'Volvo',
            'compartimentos' => [],
        ]);

        $response->assertSessionHasErrors('compartimentos');
    }

    public function test_duplicate_compartment_numbers_are_rejected(): void
    {
        $response = $this->actingAs($this->user)->post(route('veiculos.store'), [
            'placa' => 'ABC1D23',
            'modelo' => 'FH 540',
            'marca' => 'Volvo',
            'compartimentos' => [
                ['numero' => 1, 'capacidade_litros' => 10000, 'produto_atual_id' => null],
                ['numero' => 1, 'capacidade_litros' => 8000,  'produto_atual_id' => null],
            ],
        ]);

        $response->assertSessionHasErrors('compartimentos');
    }

    public function test_placa_must_be_unique(): void
    {
        Veiculo::factory()->create(['placa' => 'ABC1D23']);

        $response = $this->actingAs($this->user)->post(route('veiculos.store'), [
            'placa' => 'ABC1D23',
            'modelo' => 'FH 540',
            'marca' => 'Volvo',
            'compartimentos' => $this->oneCompartimento(),
        ]);

        $response->assertSessionHasErrors('placa');
    }

    public function test_placa_is_required(): void
    {
        $response = $this->actingAs($this->user)->post(route('veiculos.store'), [
            'placa' => '',
            'modelo' => 'FH 540',
            'marca' => 'Volvo',
            'compartimentos' => $this->oneCompartimento(),
        ]);

        $response->assertSessionHasErrors('placa');
    }

    public function test_modelo_is_required(): void
    {
        $response = $this->actingAs($this->user)->post(route('veiculos.store'), [
            'placa' => 'ABC1D23',
            'modelo' => '',
            'marca' => 'Volvo',
            'compartimentos' => $this->oneCompartimento(),
        ]);

        $response->assertSessionHasErrors('modelo');
    }

    public function test_proprietario_must_exist(): void
    {
        $response = $this->actingAs($this->user)->post(route('veiculos.store'), [
            'placa' => 'ABC1D23',
            'modelo' => 'FH 540',
            'marca' => 'Volvo',
            'proprietario_id' => 99999,
            'compartimentos' => $this->oneCompartimento(),
        ]);

        $response->assertSessionHasErrors('proprietario_id');
    }
}