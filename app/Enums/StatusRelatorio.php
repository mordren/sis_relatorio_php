<?php

namespace App\Enums;

enum StatusRelatorio: string
{
    case RASCUNHO = 'RASCUNHO';
    case EMITIDO = 'EMITIDO';
    case CANCELADO = 'CANCELADO';
    case RETIFICADO = 'RETIFICADO';

    public function label(): string
    {
        return match ($this) {
            self::RASCUNHO => 'Rascunho',
            self::EMITIDO => 'Emitido',
            self::CANCELADO => 'Cancelado',
            self::RETIFICADO => 'Retificado',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::RASCUNHO => 'bg-secondary',
            self::EMITIDO => 'bg-success',
            self::CANCELADO => 'bg-danger',
            self::RETIFICADO => 'bg-warning text-dark',
        };
    }
}
