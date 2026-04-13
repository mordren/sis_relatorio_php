<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('relatorio_equipamento_utilizados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('relatorio_id')->constrained('relatorio_descontaminacoes')->cascadeOnDelete();
            $table->foreignId('equipamento_origem_id')->nullable()->constrained('equipamentos')->nullOnDelete();
            $table->string('nome_snapshot');
            $table->string('tipo_snapshot', 20);
            $table->unsignedInteger('quantidade')->default(1);
            $table->string('numero_serie')->nullable();
            $table->text('observacao')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('relatorio_equipamento_utilizados');
    }
};
