<?php

namespace App\Models;

use App\Enums\TipoEquipamento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RelatorioEquipamentoUtilizado extends Model
{
    use HasFactory;

    protected $table = 'relatorio_equipamento_utilizados';

    protected $fillable = [
        'relatorio_id',
        'equipamento_origem_id',
        'nome_snapshot',
        'tipo_snapshot',
        'quantidade',
        'numero_serie',
        'observacao',
    ];

    protected function casts(): array
    {
        return [
            'tipo_snapshot' => TipoEquipamento::class,
            'quantidade' => 'integer',
        ];
    }

    public function relatorio(): BelongsTo
    {
        return $this->belongsTo(RelatorioDescontaminacao::class, 'relatorio_id');
    }

    /**
     * Traceability-only reference. Never use for rendering or PDF.
     */
    public function equipamentoOrigem(): BelongsTo
    {
        return $this->belongsTo(Equipamento::class, 'equipamento_origem_id');
    }
}
