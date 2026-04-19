<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipamentoMedicao extends Model
{
    use HasFactory;

    protected $table = 'equipamentos_medicao';

    protected $fillable = [
        'tipo',
        'numero_serie',
        'data_calibracao',
        'observacao',
        'ativo',
    ];

    protected function casts(): array
    {
        return [
            'data_calibracao' => 'date',
            'ativo' => 'boolean',
        ];
    }

    /**
     * Get display label for tipo enum.
     */
    public function getTypeLabel(): string
    {
        return match ($this->tipo) {
            'detector' => 'Detector de Gases',
            'explosimetro' => 'Explosímetro',
            'oximetro' => 'Oxímetro',
            default => $this->tipo,
        };
    }

    /**
     * Scope to get equipment of each type (latest).
     */
    public static function getLatestByType(): array
    {
        return [
            'detector' => static::where('tipo', 'detector')->where('ativo', true)->latest()->first(),
            'explosimetro' => static::where('tipo', 'explosimetro')->where('ativo', true)->latest()->first(),
            'oximetro' => static::where('tipo', 'oximetro')->where('ativo', true)->latest()->first(),
        ];
    }
}
