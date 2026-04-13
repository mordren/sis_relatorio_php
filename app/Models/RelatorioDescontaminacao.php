<?php

namespace App\Models;

use App\Enums\ProcessoRelatorio;
use App\Enums\StatusRelatorio;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RelatorioDescontaminacao extends Model
{
    use HasFactory;

    protected $table = 'relatorio_descontaminacoes';

    protected $fillable = [
        'numero_relatorio',
        'status',
        'data_servico',
        'responsavel_tecnico_id',
        'processo',
        'observacoes',
        'lacre_entrada',
        'lacre_saida',
        'criado_por_id',
        'emitido_em',
        'cancelado_em',
        'motivo_cancelamento',
    ];

    protected function casts(): array
    {
        return [
            'status' => StatusRelatorio::class,
            'processo' => ProcessoRelatorio::class,
            'data_servico' => 'date',
            'emitido_em' => 'datetime',
            'cancelado_em' => 'datetime',
        ];
    }

    public function responsavelTecnico(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_tecnico_id');
    }

    public function criadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'criado_por_id');
    }

    public function clienteSnapshot(): HasOne
    {
        return $this->hasOne(RelatorioClienteSnapshot::class, 'relatorio_id');
    }

    public function veiculoSnapshot(): HasOne
    {
        return $this->hasOne(RelatorioVeiculoSnapshot::class, 'relatorio_id');
    }

    public function finalidades(): HasMany
    {
        return $this->hasMany(RelatorioFinalidade::class, 'relatorio_id');
    }

    public function compartimentos(): HasMany
    {
        return $this->hasMany(RelatorioCompartimento::class, 'relatorio_id');
    }

    public function equipamentosUtilizados(): HasMany
    {
        return $this->hasMany(RelatorioEquipamentoUtilizado::class, 'relatorio_id');
    }
}
