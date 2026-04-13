<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Extend relatorio_compartimentos with SRD chemical/operational fields
 * and make capacidade_litros nullable.
 *
 * Compartment detail is now entered inside the report (not copied from the
 * vehicle master), so rows are created empty and filled by the user on the
 * report edit page. capacidade_litros is therefore nullable at creation time.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('relatorio_compartimentos', function (Blueprint $table) {
            // Make capacidade_litros nullable – it is filled on the report edit page.
            $table->decimal('capacidade_litros', 12, 2)->nullable()->change();

            // SRD product snapshot fields (appended after produto_anterior_nome)
            $table->string('numero_onu', 50)->nullable()->after('produto_anterior_nome');
            $table->string('classe_risco', 100)->nullable()->after('numero_onu');

            // Chemical / operational fields (dimensioned for precision)
            $table->decimal('pressao_vapor', 10, 4)->nullable()->after('classe_risco');
            $table->unsignedInteger('tempo_minutos')->nullable()->after('pressao_vapor');
            $table->decimal('massa_vapor', 14, 4)->nullable()->after('tempo_minutos');
            $table->decimal('volume_ar', 14, 4)->nullable()->after('massa_vapor');
            $table->string('neutralizante', 255)->nullable()->after('volume_ar');
        });
    }

    public function down(): void
    {
        Schema::table('relatorio_compartimentos', function (Blueprint $table) {
            $table->dropColumn([
                'numero_onu',
                'classe_risco',
                'pressao_vapor',
                'tempo_minutos',
                'massa_vapor',
                'volume_ar',
                'neutralizante',
            ]);

            // Restore NOT NULL on capacidade_litros (may fail if NULLs exist)
            $table->decimal('capacidade_litros', 12, 2)->nullable(false)->change();
        });
    }
};
