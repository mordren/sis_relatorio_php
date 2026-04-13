<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Veiculo extends Model
{
    use HasFactory;

    protected $fillable = [
        'placa',
        'modelo',
        'marca',
        'ano',
        'tipo_veiculo',
        'numero_compartimentos',
        'proprietario_id',
        'ativo',
    ];

    protected function casts(): array
    {
        return [
            'ano' => 'integer',
            'numero_compartimentos' => 'integer',
            'ativo' => 'boolean',
        ];
    }

    public function proprietario(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'proprietario_id');
    }

    public function compartimentos(): HasMany
    {
        return $this->hasMany(VeiculoCompartimento::class);
    }
}
