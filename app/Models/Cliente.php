<?php

namespace App\Models;

use App\Enums\TipoPessoa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_pessoa',
        'nome_razao_social',
        'cpf_cnpj',
        'endereco',
        'cidade',
        'estado',
        'telefone',
        'email',
        'ativo',
    ];

    protected function casts(): array
    {
        return [
            'tipo_pessoa' => TipoPessoa::class,
            'ativo' => 'boolean',
        ];
    }

    public function veiculos(): HasMany
    {
        return $this->hasMany(Veiculo::class, 'proprietario_id');
    }
}
