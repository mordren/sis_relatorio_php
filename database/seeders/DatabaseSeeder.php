<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Equipamento;
use App\Models\ProdutoTransportado;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Veiculo;
use App\Models\VeiculoCompartimento;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@descontaminacao.com',
            'password' => Hash::make('password'),
        ]);

        UserProfile::factory()->create([
            'user_id' => $admin->id,
            'cargo' => 'Engenheiro Químico',
            'registro_profissional' => 'CRQ-0412345',
        ]);

        // Create a second user
        $tecnico = User::factory()->create([
            'name' => 'Carlos Técnico',
            'email' => 'tecnico@descontaminacao.com',
            'password' => Hash::make('password'),
        ]);

        UserProfile::factory()->create([
            'user_id' => $tecnico->id,
            'cargo' => 'Técnico em Química',
        ]);

        // Create sample clients
        $clientePF = Cliente::factory()->pessoaFisica()->create([
            'nome_razao_social' => 'José da Silva',
            'cpf_cnpj' => '12345678901',
        ]);

        $clientePJ = Cliente::factory()->pessoaJuridica()->create([
            'nome_razao_social' => 'Transportadora ABC Ltda',
            'cpf_cnpj' => '12345678000190',
        ]);

        // Create sample products
        $diesel = ProdutoTransportado::factory()->create([
            'nome' => 'Diesel S500',
            'classe_risco' => '3',
            'numero_onu' => '1202',
        ]);

        $gasolina = ProdutoTransportado::factory()->create([
            'nome' => 'Gasolina Comum',
            'classe_risco' => '3',
            'numero_onu' => '1203',
        ]);

        // Create sample vehicles with compartments
        $veiculo1 = Veiculo::factory()->create([
            'placa' => 'ABC1D23',
            'modelo' => 'FH 540',
            'marca' => 'Volvo',
            'ano' => 2022,
            'tipo_veiculo' => 'Caminhão Tanque',
            'proprietario_id' => $clientePJ->id,
        ]);

        VeiculoCompartimento::create([
            'veiculo_id' => $veiculo1->id,
            'numero' => 1,
            'capacidade_litros' => 15000.00,
            'produto_atual_id' => $diesel->id,
        ]);

        VeiculoCompartimento::create([
            'veiculo_id' => $veiculo1->id,
            'numero' => 2,
            'capacidade_litros' => 10000.00,
            'produto_atual_id' => $gasolina->id,
        ]);

        Veiculo::factory()->create([
            'placa' => 'XYZ9W88',
            'modelo' => 'R 450',
            'marca' => 'Scania',
            'ano' => 2023,
            'tipo_veiculo' => 'Carreta Tanque',
            'proprietario_id' => $clientePF->id,
        ]);

        // Create sample equipment
        Equipamento::factory()->create([
            'nome' => 'Luva Nitrílica',
            'tipo' => 'EPI',
        ]);

        Equipamento::factory()->create([
            'nome' => 'Bomba Centrífuga BC-200',
            'tipo' => 'BOMBA',
        ]);

        Equipamento::factory()->create([
            'nome' => 'Lavadora de Alta Pressão WAP',
            'tipo' => 'LAVADORA',
        ]);
    }
}
