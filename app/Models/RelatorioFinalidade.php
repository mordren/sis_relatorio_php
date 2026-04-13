<?php

namespace App\Models;

use App\Enums\FinalidadeRelatorio;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RelatorioFinalidade extends Model
{
    use HasFactory;

    protected $fillable = [
        'relatorio_id',
        'finalidade',
        'descricao_outros',
    ];

    protected function casts(): array
    {
        return [
            'finalidade' => FinalidadeRelatorio::class,
        ];
    }

    public function relatorio(): BelongsTo
    {
        return $this->belongsTo(RelatorioDescontaminacao::class, 'relatorio_id');
    }
}
