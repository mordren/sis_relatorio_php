<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('relatorio_compartimentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('relatorio_id')->constrained('relatorio_descontaminacoes')->cascadeOnDelete();
            $table->foreignId('compartimento_origem_id')->nullable()->constrained('veiculo_compartimentos')->nullOnDelete();
            $table->unsignedInteger('numero');
            $table->decimal('capacidade_litros', 12, 2);
            $table->string('produto_anterior_nome')->nullable();
            $table->string('lacre_entrada_numero')->nullable();
            $table->string('lacre_saida_numero')->nullable();
            $table->text('observacao')->nullable();
            $table->timestamps();

            $table->unique(['relatorio_id', 'numero']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('relatorio_compartimentos');
    }
};
