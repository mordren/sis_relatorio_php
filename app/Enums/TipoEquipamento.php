<?php

namespace App\Enums;

enum TipoEquipamento: string
{
    case EPI = 'EPI';
    case BOMBA = 'BOMBA';
    case MANGUEIRA = 'MANGUEIRA';
    case ESCOVA = 'ESCOVA';
    case LAVADORA = 'LAVADORA';
    case OUTROS = 'OUTROS';

    public function label(): string
    {
        return match ($this) {
            self::EPI => 'EPI',
            self::BOMBA => 'Bomba',
            self::MANGUEIRA => 'Mangueira',
            self::ESCOVA => 'Escova',
            self::LAVADORA => 'Lavadora',
            self::OUTROS => 'Outros',
        };
    }
}
