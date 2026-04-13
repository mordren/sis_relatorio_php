<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('relatorio_descontaminacoes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_relatorio')->unique();
            $table->string('status', 20)->default('RASCUNHO'); // RASCUNHO, EMITIDO, CANCELADO, RETIFICADO
            $table->date('data_servico');
            $table->foreignId('responsavel_tecnico_id')->constrained('users')->restrictOnDelete();
            $table->string('processo', 20); // LAVAGEM, NEUTRALIZACAO, QUIMICO, VAPOR, OUTROS
            $table->text('observacoes')->nullable();
            $table->string('lacre_entrada')->nullable();
            $table->string('lacre_saida')->nullable();
            $table->foreignId('criado_por_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('emitido_em')->nullable();
            $table->timestamp('cancelado_em')->nullable();
            $table->text('motivo_cancelamento')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('relatorio_descontaminacoes');
    }
};
