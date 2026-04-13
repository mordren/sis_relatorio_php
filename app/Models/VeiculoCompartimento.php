<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VeiculoCompartimento extends Model
{
    use HasFactory;

    protected $fillable = [
        'veiculo_id',
        'numero',
        'capacidade_litros',
        'produto_atual_id',
    ];

    protected function casts(): array
    {
        return [
            'numero' => 'integer',
            'capacidade_litros' => 'decimal:2',
        ];
    }

    public function veiculo(): BelongsTo
    {
        return $this->belongsTo(Veiculo::class);
    }

    public function produtoAtual(): BelongsTo
    {
        return $this->belongsTo(ProdutoTransportado::class, 'produto_atual_id');
    }
}
