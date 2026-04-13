<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Normalise numero_relatorio from prefixed string (e.g. "REL-000001") to an
 * unsigned integer (e.g. 1).  Fresh installs will have zero rows so the data
 * migration step is a no-op; upgrading installations are handled gracefully.
 *
 * Compatibility note: if any existing rows contain a non-numeric prefix they
 * will be stripped before the column type is altered.  The unique index is
 * recreated on the new integer column.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Step 1 – strip any "REL-" (or similar) prefix from existing rows.
        //          REGEXP is not available in SQLite (tests use in-memory SQLite
        //          with RefreshDatabase so there are never any existing rows;
        //          only run this on MySQL/MariaDB).
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("
                UPDATE relatorio_descontaminacoes
                SET numero_relatorio = CAST(
                    LTRIM(REPLACE(REPLACE(numero_relatorio, 'REL-', ''), 'REL', ''), '0') AS UNSIGNED
                )
                WHERE numero_relatorio REGEXP '[^0-9]'
            ");
        }

        // Step 2 – drop the old unique index on the string column (SQLite does
        //          not support in-place ALTER COLUMN, so we recreate the table
        //          internally; on MySQL/Postgres the index is dropped first).
        Schema::table('relatorio_descontaminacoes', function (Blueprint $table) {
            // Drop index if it exists (will be recreated after type change)
            try {
                $table->dropUnique(['numero_relatorio']);
            } catch (\Throwable) {
                // Index may already be named differently – ignore
            }
        });

        // Step 3 – change the column to unsignedBigInteger
        Schema::table('relatorio_descontaminacoes', function (Blueprint $table) {
            $table->unsignedBigInteger('numero_relatorio')->change();
        });

        // Step 4 – add unique index back on the integer column
        Schema::table('relatorio_descontaminacoes', function (Blueprint $table) {
            $table->unique('numero_relatorio');
        });
    }

    public function down(): void
    {
        Schema::table('relatorio_descontaminacoes', function (Blueprint $table) {
            try {
                $table->dropUnique(['numero_relatorio']);
            } catch (\Throwable) {
            }
        });

        Schema::table('relatorio_descontaminacoes', function (Blueprint $table) {
            $table->string('numero_relatorio', 50)->change();
        });

        Schema::table('relatorio_descontaminacoes', function (Blueprint $table) {
            $table->unique('numero_relatorio');
        });
    }
};
