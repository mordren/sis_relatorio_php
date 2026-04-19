<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipamentos_medicao', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['detector', 'explosimetro', 'oximetro']);
            $table->string('numero_serie')->unique();
            $table->date('data_calibracao')->nullable();
            $table->text('observacao')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipamentos_medicao');
    }
};
