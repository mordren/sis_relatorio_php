<?php

namespace App\Enums;

enum FinalidadeRelatorio: string
{
    case VERIFICACAO_METROLOGICA = 'VERIFICACAO_METROLOGICA';
    case MANUTENCAO = 'MANUTENCAO';
    case TROCA_PRODUTO = 'TROCA_PRODUTO';
    case INSPECAO = 'INSPECAO';
    case DESCARTE = 'DESCARTE';
    case CERTIFICACAO = 'CERTIFICACAO';
    case OUTROS = 'OUTROS';

    public function label(): string
    {
        return match ($this) {
            self::VERIFICACAO_METROLOGICA => 'Verificação Metrológica',
            self::MANUTENCAO => 'Manutenção',
            self::TROCA_PRODUTO => 'Troca de Produto',
            self::INSPECAO => 'Inspeção',
            self::DESCARTE => 'Descarte',
            self::CERTIFICACAO => 'Certificação',
            self::OUTROS => 'Outros',
        };
    }
}
