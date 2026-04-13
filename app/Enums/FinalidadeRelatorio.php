<?php

namespace App\Enums;

enum FinalidadeRelatorio: string
{
    case MANUTENCAO = 'MANUTENCAO';
    case TROCA_PRODUTO = 'TROCA_PRODUTO';
    case INSPECAO = 'INSPECAO';
    case DESCARTE = 'DESCARTE';
    case CERTIFICACAO = 'CERTIFICACAO';
    case OUTROS = 'OUTROS';

    public function label(): string
    {
        return match ($this) {
            self::MANUTENCAO => 'Manutenção',
            self::TROCA_PRODUTO => 'Troca de Produto',
            self::INSPECAO => 'Inspeção',
            self::DESCARTE => 'Descarte',
            self::CERTIFICACAO => 'Certificação',
            self::OUTROS => 'Outros',
        };
    }
}
