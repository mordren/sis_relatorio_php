<?php

namespace Tests\Feature;

use App\Enums\TipoPessoa;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClienteTest extends TestCase
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
        $response = $this->get(route('clientes.create'));

        $response->assertRedirect('/login');
    }

    public function test_create_page_is_accessible(): void
    {
        $response = $this->actingAs($this->user)->get(route('clientes.create'));

        $response->assertStatus(200);
        $response->assertSee('Cadastrar Cliente');
    }

    public function test_can_create_pessoa_fisica(): void
    {
        $response = $this->actingAs($this->user)->post(route('clientes.store'), [
            'tipo_pessoa' => 'PF',
            'nome_razao_social' => 'João da Silva',
            'cpf_cnpj' => '12345678901',
            'endereco' => 'Rua das Flores, 100',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'telefone' => '11999998888',
            'email' => 'joao@example.com',
        ]);

        $response->assertRedirect(route('clientes.create'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('clientes', [
            'tipo_pessoa' => 'PF',
            'nome_razao_social' => 'João da Silva',
            'cpf_cnpj' => '12345678901',
        ]);
    }

    public function test_can_create_pessoa_juridica(): void
    {
        $response = $this->actingAs($this->user)->post(route('clientes.store'), [
            'tipo_pessoa' => 'PJ',
            'nome_razao_social' => 'Empresa XYZ Ltda',
            'cpf_cnpj' => '12345678000190',
            'cidade' => 'Rio de Janeiro',
            'estado' => 'RJ',
        ]);

        $response->assertRedirect(route('clientes.create'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('clientes', [
            'tipo_pessoa' => 'PJ',
            'cpf_cnpj' => '12345678000190',
        ]);
    }

    public function test_pf_rejects_invalid_cpf_length(): void
    {
        $response = $this->actingAs($this->user)->post(route('clientes.store'), [
            'tipo_pessoa' => 'PF',
            'nome_razao_social' => 'João',
            'cpf_cnpj' => '1234567890', // 10 digits, should be 11
        ]);

        $response->assertSessionHasErrors('cpf_cnpj');
    }

    public function test_pj_rejects_invalid_cnpj_length(): void
    {
        $response = $this->actingAs($this->user)->post(route('clientes.store'), [
            'tipo_pessoa' => 'PJ',
            'nome_razao_social' => 'Empresa',
            'cpf_cnpj' => '1234567800019', // 13 digits, should be 14
        ]);

        $response->assertSessionHasErrors('cpf_cnpj');
    }

    public function test_cpf_cnpj_must_be_unique(): void
    {
        Cliente::factory()->create(['cpf_cnpj' => '12345678901', 'tipo_pessoa' => 'PF']);

        $response = $this->actingAs($this->user)->post(route('clientes.store'), [
            'tipo_pessoa' => 'PF',
            'nome_razao_social' => 'Outro João',
            'cpf_cnpj' => '12345678901',
        ]);

        $response->assertSessionHasErrors('cpf_cnpj');
    }

    public function test_cpf_cnpj_must_contain_only_digits(): void
    {
        $response = $this->actingAs($this->user)->post(route('clientes.store'), [
            'tipo_pessoa' => 'PF',
            'nome_razao_social' => 'João',
            'cpf_cnpj' => '123.456.789-01',
        ]);

        $response->assertSessionHasErrors('cpf_cnpj');
    }

    public function test_nome_razao_social_is_required(): void
    {
        $response = $this->actingAs($this->user)->post(route('clientes.store'), [
            'tipo_pessoa' => 'PF',
            'nome_razao_social' => '',
            'cpf_cnpj' => '12345678901',
        ]);

        $response->assertSessionHasErrors('nome_razao_social');
    }

    public function test_tipo_pessoa_is_required(): void
    {
        $response = $this->actingAs($this->user)->post(route('clientes.store'), [
            'tipo_pessoa' => '',
            'nome_razao_social' => 'João',
            'cpf_cnpj' => '12345678901',
        ]);

        $response->assertSessionHasErrors('tipo_pessoa');
    }
}
