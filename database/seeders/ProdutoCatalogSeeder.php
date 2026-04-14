<?php

namespace Database\Seeders;

use App\Models\ProdutoTransportado;
use Illuminate\Database\Seeder;

/**
 * Canonical product catalog for the VAPOR decontamination workflow.
 * Maps product names to their UN numbers and hazard class.
 *
 * Source: ADR/Brazilian transport regulation + user SRD specification.
 */
class ProdutoCatalogSeeder extends Seeder
{
    public function run(): void
    {
        // Skip if already seeded (production safety guard)
        if (ProdutoTransportado::exists()) {
            return;
        }

        $produtos = [
            // OLEO LUBRIFICANTE intentionally left without ONU (no UN number)
            ['nome' => 'OLEO LUBRIFICANTE',       'classe_risco' => '3',  'numero_onu' => null],
            ['nome' => 'LIQUIDO INFLAMAVEL, N.E.', 'classe_risco' => '3',  'numero_onu' => '1993'],
            ['nome' => 'ACIDO CLORIDRICO',         'classe_risco' => '8',  'numero_onu' => '1789'],
            ['nome' => 'XILENOS',                  'classe_risco' => '3',  'numero_onu' => '1307'],
            ['nome' => 'TOLUENO',                  'classe_risco' => '3',  'numero_onu' => '1294'],
            ['nome' => 'METANOL',                  'classe_risco' => '3',  'numero_onu' => '1230'],
            ['nome' => 'QUEROSENE',                'classe_risco' => '3',  'numero_onu' => '1223'],
            ['nome' => 'BENZENO',                  'classe_risco' => '3',  'numero_onu' => '1114'],
            ['nome' => 'ETANOL',                   'classe_risco' => '3',  'numero_onu' => '1170'],
            ['nome' => 'GASOLINA',                 'classe_risco' => '3',  'numero_onu' => '1203'],
            ['nome' => 'DIESEL',                   'classe_risco' => '3',  'numero_onu' => '1202'],
            ['nome' => 'GAS-ETANOL',               'classe_risco' => '3',  'numero_onu' => '3475'],
        ];

        foreach ($produtos as $produto) {
            ProdutoTransportado::create(array_merge($produto, ['ativo' => true]));
        }
    }
}
