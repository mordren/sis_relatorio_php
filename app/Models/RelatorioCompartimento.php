<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RelatorioCompartimento extends Model
{
    use HasFactory;

    protected $fillable = [
        'relatorio_id',
        'compartimento_origem_id',
        'numero',
        'capacidade_litros',
        'produto_anterior_nome',
        'numero_onu',
        'classe_risco',
        'pressao_vapor',
        'tempo_minutos',
        'massa_vapor',
        'volume_ar',
        'neutralizante',
        'lacre_entrada_numero',
        'lacre_saida_numero',
        'observacao',
    ];

    protected function casts(): array
    {
        return [
            'numero' => 'integer',
            'capacidade_litros' => 'decimal:2',
            'pressao_vapor' => 'decimal:4',
            'tempo_minutos' => 'integer',
            'massa_vapor' => 'decimal:4',
            'volume_ar' => 'decimal:4',
        ];
    }

    public function relatorio(): BelongsTo
    {
        return $this->belongsTo(RelatorioDescontaminacao::class, 'relatorio_id');
    }

    /**
     * Traceability-only reference. Never use for rendering or PDF.
     */
    public function compartimentoOrigem(): BelongsTo
    {
        return $this->belongsTo(VeiculoCompartimento::class, 'compartimento_origem_id');
    }
}
