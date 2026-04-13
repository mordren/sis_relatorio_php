<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoTransportado extends Model
{
    use HasFactory;

    protected $table = 'produtos_transportados';

    protected $fillable = [
        'nome',
        'classe_risco',
        'numero_onu',
        'ativo',
    ];

    protected function casts(): array
    {
        return [
            'ativo' => 'boolean',
        ];
    }
}
