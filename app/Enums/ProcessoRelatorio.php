<?php

namespace App\Enums;

enum ProcessoRelatorio: string
{
    case LAVAGEM = 'LAVAGEM';
    case NEUTRALIZACAO = 'NEUTRALIZACAO';
    case QUIMICO = 'QUIMICO';
    case VAPOR = 'VAPOR';
    case OUTROS = 'OUTROS';

    public function label(): string
    {
        return match ($this) {
            self::LAVAGEM => 'Lavagem',
            self::NEUTRALIZACAO => 'Neutralização',
            self::QUIMICO => 'Químico',
            self::VAPOR => 'Vapor',
            self::OUTROS => 'Outros',
        };
    }
}
