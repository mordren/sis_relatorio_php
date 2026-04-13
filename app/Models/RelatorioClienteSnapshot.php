<?php

namespace App\Models;

use App\Enums\TipoPessoa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RelatorioClienteSnapshot extends Model
{
    use HasFactory;

    protected $fillable = [
        'relatorio_id',
        'cliente_origem_id',
        'tipo_pessoa',
        'nome_razao_social',
        'cpf_cnpj',
        'endereco',
        'cidade',
        'estado',
        'telefone',
        'email',
    ];

    protected function casts(): array
    {
        return [
            'tipo_pessoa' => TipoPessoa::class,
        ];
    }

    public function relatorio(): BelongsTo
    {
        return $this->belongsTo(RelatorioDescontaminacao::class, 'relatorio_id');
    }

    /**
     * Traceability-only reference. Never use for rendering or PDF.
     */
    public function clienteOrigem(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_origem_id');
    }
}
