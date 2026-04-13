<?php

namespace App\Enums;

enum TipoPessoa: string
{
    case PF = 'PF';
    case PJ = 'PJ';

    public function label(): string
    {
        return match ($this) {
            self::PF => 'Pessoa Física',
            self::PJ => 'Pessoa Jurídica',
        };
    }

    public function cpfCnpjLength(): int
    {
        return match ($this) {
            self::PF => 11,
            self::PJ => 14,
        };
    }
}
