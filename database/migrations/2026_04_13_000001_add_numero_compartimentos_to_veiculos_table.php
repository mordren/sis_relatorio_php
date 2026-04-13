<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add numero_compartimentos to veiculos.
 *
 * The vehicle no longer requires detailed VeiculoCompartimento rows to operate.
 * The number of compartments drives report snapshot creation at report issuance time.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('veiculos', function (Blueprint $table) {
            $table->unsignedSmallInteger('numero_compartimentos')->default(1)->after('tipo_veiculo');
        });
    }

    public function down(): void
    {
        Schema::table('veiculos', function (Blueprint $table) {
            $table->dropColumn('numero_compartimentos');
        });
    }
};
