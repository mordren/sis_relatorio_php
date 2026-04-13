<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('veiculo_compartimentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('veiculo_id')->constrained('veiculos')->cascadeOnDelete();
            $table->unsignedInteger('numero');
            $table->decimal('capacidade_litros', 12, 2);
            $table->foreignId('produto_atual_id')->nullable()->constrained('produtos_transportados')->nullOnDelete();
            $table->timestamps();

            $table->unique(['veiculo_id', 'numero']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('veiculo_compartimentos');
    }
};
