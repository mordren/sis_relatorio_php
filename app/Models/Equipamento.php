<?php

namespace App\Models;

use App\Enums\TipoEquipamento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'tipo',
        'descricao',
        'ativo',
    ];

    protected function casts(): array
    {
        return [
            'tipo' => TipoEquipamento::class,
            'ativo' => 'boolean',
        ];
    }
}
