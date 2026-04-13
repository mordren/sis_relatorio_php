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

    public function test_create_page_requires_authentication(): void
    {
        $response = $this->get(route('veiculos.create'));

        $response->assertRedirect('/login');
    }

    public function test_create_page_is_accessible(): void
    {
        $response = $this->actingAs($this->user)->get(route('veiculos.create'));

        $response->assertStatus(200);
        $response->assertSee('Cadastrar Veículo');
    }

    public function test_create_page_shows_active_client_count(): void
    {
        Cliente::factory()->count(3)->create(['ativo' => true]);
        Cliente::factory()->create(['ativo' => false]);

        $response = $this->actingAs($this->user)->get(route('veiculos.create'));

        $response->assertStatus(200);
        $response->assertSee('3 clientes ativos disponíveis');
    }

    public function test_can_create_vehicle(): void
    {
        $response = $this->actingAs($this->user)->post(route('veiculos.store'), [
            'placa' => 'ABC1D23',
            'modelo' => 'FH 540',
            'marca' => 'Volvo',
            'ano' => 2022,
            'tipo_veiculo' => 'Caminhão Tanque',
        ]);

        $response->assertRedirect(route('veiculos.create'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('veiculos', [
            'placa' => 'ABC1D23',
            'modelo' => 'FH 540',
            'marca' => 'Volvo',
        ]);
    }

    public function test_can_create_vehicle_with_owner(): void
    {
        $cliente = Cliente::factory()->create();

        $response = $this->actingAs($this->user)->post(route('veiculos.store'), [
            'placa' => 'XYZ9W88',
            'modelo' => 'R 450',
            'marca' => 'Scania',
            'proprietario_id' => $cliente->id,
        ]);

        $response->assertRedirect(route('veiculos.create'));

        $veiculo = Veiculo::where('placa', 'XYZ9W88')->first();
        $this->assertNotNull($veiculo);
        $this->assertEquals($cliente->id, $veiculo->proprietario_id);
    }

    public function test_placa_must_be_unique(): void
    {
        Veiculo::factory()->create(['placa' => 'ABC1D23']);

        $response = $this->actingAs($this->user)->post(route('veiculos.store'), [
            'placa' => 'ABC1D23',
            'modelo' => 'FH 540',
            'marca' => 'Volvo',
        ]);

        $response->assertSessionHasErrors('placa');
    }

    public function test_placa_is_required(): void
    {
        $response = $this->actingAs($this->user)->post(route('veiculos.store'), [
            'placa' => '',
            'modelo' => 'FH 540',
            'marca' => 'Volvo',
        ]);

        $response->assertSessionHasErrors('placa');
    }

    public function test_modelo_is_required(): void
    {
        $response = $this->actingAs($this->user)->post(route('veiculos.store'), [
            'placa' => 'ABC1D23',
            'modelo' => '',
            'marca' => 'Volvo',
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
        ]);

        $response->assertSessionHasErrors('proprietario_id');
    }
}
