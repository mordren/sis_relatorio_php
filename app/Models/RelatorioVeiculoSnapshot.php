<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RelatorioVeiculoSnapshot extends Model
{
    use HasFactory;

    protected $fillable = [
        'relatorio_id',
        'veiculo_origem_id',
        'placa',
        'modelo',
        'marca',
        'ano',
        'tipo_veiculo',
        'numero_equipamento',
    ];

    protected function casts(): array
    {
        return [
            'ano' => 'integer',
        ];
    }

    public function relatorio(): BelongsTo
    {
        return $this->belongsTo(RelatorioDescontaminacao::class, 'relatorio_id');
    }

    /**
     * Traceability-only reference. Never use for rendering or PDF.
     */
    public function veiculoOrigem(): BelongsTo
    {
        return $this->belongsTo(Veiculo::class, 'veiculo_origem_id');
    }
}
