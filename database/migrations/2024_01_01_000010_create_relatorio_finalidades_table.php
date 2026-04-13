<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('relatorio_finalidades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('relatorio_id')->constrained('relatorio_descontaminacoes')->cascadeOnDelete();
            $table->string('finalidade', 30); // MANUTENCAO, TROCA_PRODUTO, INSPECAO, DESCARTE, CERTIFICACAO, OUTROS
            $table->string('descricao_outros')->nullable();
            $table->timestamps();

            $table->unique(['relatorio_id', 'finalidade']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('relatorio_finalidades');
    }
};
