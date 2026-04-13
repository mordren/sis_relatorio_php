<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('relatorio_cliente_snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('relatorio_id')->unique()->constrained('relatorio_descontaminacoes')->cascadeOnDelete();
            $table->foreignId('cliente_origem_id')->nullable()->constrained('clientes')->nullOnDelete();
            $table->string('tipo_pessoa', 2);
            $table->string('nome_razao_social');
            $table->string('cpf_cnpj', 14);
            $table->string('endereco')->nullable();
            $table->string('cidade')->nullable();
            $table->string('estado', 2)->nullable();
            $table->string('telefone', 20)->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('relatorio_cliente_snapshots');
    }
};
