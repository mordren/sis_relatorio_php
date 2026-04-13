<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\User;
use App\Models\Veiculo;
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

    private function validVeiculoPayload(array $overrides = []): array
    {
        return array_merge([
            'placa' => 'ABC1D23',
            'modelo' => 'FH 540',
            'marca' => 'Volvo',
            'ano' => 2022,
            'tipo_veiculo' => 'Caminhão Tanque',
            'numero_compartimentos' => 3,
        ], $overrides);
    }

    // -----------------------------------------------------------------------
    // Page access
    // -----------------------------------------------------------------------

    public function test_create_page_requires_authentication(): void
    {
        $this->get(route('veiculos.create'))
            ->assertRedirect('/login');
    }

    public function test_create_page_is_accessible(): void
    {
        $this->actingAs($this->user)
            ->get(route('veiculos.create'))
            ->assertStatus(200)
            ->assertSee('Cadastrar');
    }

    public function test_create_page_shows_active_client_count(): void
    {
        Cliente::factory()->count(3)->create(['ativo' => true]);
        Cliente::factory()->create(['ativo' => false]);

        $this->actingAs($this->user)
            ->get(route('veiculos.create'))
            ->assertStatus(200)
            ->assertSee('3 clientes ativos');
    }

    public function test_create_page_does_not_have_detailed_compartment_rows(): void
    {
        $this->actingAs($this->user)
            ->get(route('veiculos.create'))
            ->assertStatus(200)
            ->assertSee('numero_compartimentos')
            ->assertDontSee('capacidade_litros');
    }

    // -----------------------------------------------------------------------
    // Successful creation
    // -----------------------------------------------------------------------

    public function test_can_create_vehicle(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('veiculos.store'), $this->validVeiculoPayload());

        $response->assertRedirect(route('veiculos.create'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('veiculos', [
            'placa' => 'ABC1D23',
            'modelo' => 'FH 540',
            'marca' => 'Volvo',
            'numero_compartimentos' => 3,
        ]);
    }

    public function test_numero_compartimentos_is_stored(): void
    {
        $this->actingAs($this->user)
            ->post(route('veiculos.store'), $this->validVeiculoPayload(['numero_compartimentos' => 5]));

        $veiculo = Veiculo::where('placa', 'ABC1D23')->first();
        $this->assertNotNull($veiculo);
        $this->assertEquals(5, $veiculo->numero_compartimentos);
    }

    public function test_vehicle_creation_does_not_create_veiculo_compartimento_rows(): void
    {
        $this->actingAs($this->user)
            ->post(route('veiculos.store'), $this->validVeiculoPayload(['numero_compartimentos' => 4]));

        $this->assertDatabaseCount('veiculo_compartimentos', 0);
    }

    public function test_can_create_vehicle_with_owner(): void
    {
        $cliente = Cliente::factory()->create();

        $this->actingAs($this->user)->post(route('veiculos.store'), $this->validVeiculoPayload([
            'placa' => 'XYZ9W88',
            'proprietario_id' => $cliente->id,
        ]));

        $veiculo = Veiculo::where('placa', 'XYZ9W88')->first();
        $this->assertNotNull($veiculo);
        $this->assertEquals($cliente->id, $veiculo->proprietario_id);
    }

    // -----------------------------------------------------------------------
    // Validation: numero_compartimentos
    // -----------------------------------------------------------------------

    public function test_numero_compartimentos_is_required(): void
    {
        $payload = $this->validVeiculoPayload();
        unset($payload['numero_compartimentos']);

        $this->actingAs($this->user)
            ->post(route('veiculos.store'), $payload)
            ->assertSessionHasErrors('numero_compartimentos');
    }

    public function test_numero_compartimentos_must_be_at_least_one(): void
    {
        $this->actingAs($this->user)
            ->post(route('veiculos.store'), $this->validVeiculoPayload(['numero_compartimentos' => 0]))
            ->assertSessionHasErrors('numero_compartimentos');
    }

    public function test_numero_compartimentos_must_be_integer(): void
    {
        $this->actingAs($this->user)
            ->post(route('veiculos.store'), $this->validVeiculoPayload(['numero_compartimentos' => 'abc']))
            ->assertSessionHasErrors('numero_compartimentos');
    }

    // -----------------------------------------------------------------------
    // Validation: other fields
    // -----------------------------------------------------------------------

    public function test_placa_must_be_unique(): void
    {
        Veiculo::factory()->create(['placa' => 'ABC1D23']);

        $this->actingAs($this->user)
            ->post(route('veiculos.store'), $this->validVeiculoPayload())
            ->assertSessionHasErrors('placa');
    }

    public function test_placa_is_required(): void
    {
        $this->actingAs($this->user)
            ->post(route('veiculos.store'), $this->validVeiculoPayload(['placa' => '']))
            ->assertSessionHasErrors('placa');
    }

    public function test_modelo_is_required(): void
    {
        $this->actingAs($this->user)
            ->post(route('veiculos.store'), $this->validVeiculoPayload(['modelo' => '']))
            ->assertSessionHasErrors('modelo');
    }

    public function test_marca_is_required(): void
    {
        $this->actingAs($this->user)
            ->post(route('veiculos.store'), $this->validVeiculoPayload(['marca' => '']))
            ->assertSessionHasErrors('marca');
    }

    public function test_proprietario_must_exist(): void
    {
        $this->actingAs($this->user)
            ->post(route('veiculos.store'), $this->validVeiculoPayload(['proprietario_id' => 99999]))
            ->assertSessionHasErrors('proprietario_id');
    }
}
