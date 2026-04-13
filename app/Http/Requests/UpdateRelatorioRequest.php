<?php

namespace App\Http\Requests;

use App\Enums\ProcessoRelatorio;
use App\Models\RelatorioCompartimento;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRelatorioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Report-level fields
            'data_servico' => ['required', 'date'],
            'responsavel_tecnico_id' => ['required', 'exists:users,id'],
            'processo' => ['required', Rule::enum(ProcessoRelatorio::class)],
            'observacoes' => ['nullable', 'string', 'max:5000'],
            'lacre_entrada' => [
                'nullable',
                'string',
                'max:255',
                'required_with:lacre_saida',
            ],
            'lacre_saida' => ['nullable', 'string', 'max:255'],

            // Compartimento snapshot rows
            'compartimentos' => ['required', 'array', 'min:1'],
            'compartimentos.*.id' => ['required', 'integer'],
            'compartimentos.*.numero' => ['required', 'integer', 'min:1'],
            // capacidade_litros is filled on the edit page; nullable at this point
            'compartimentos.*.capacidade_litros' => ['nullable', 'numeric', 'gt:0'],
            'compartimentos.*.produto_anterior_nome' => ['nullable', 'string', 'max:255'],
            // SRD chemical / product fields
            'compartimentos.*.numero_onu' => ['nullable', 'string', 'max:50'],
            'compartimentos.*.classe_risco' => ['nullable', 'string', 'max:100'],
            'compartimentos.*.pressao_vapor' => ['nullable', 'numeric', 'min:0'],
            'compartimentos.*.tempo_minutos' => ['nullable', 'integer', 'min:0'],
            'compartimentos.*.massa_vapor' => ['nullable', 'numeric', 'min:0'],
            'compartimentos.*.volume_ar' => ['nullable', 'numeric', 'min:0'],
            'compartimentos.*.neutralizante' => ['nullable', 'string', 'max:255'],
            // Seal fields
            'compartimentos.*.lacre_entrada_numero' => ['nullable', 'string', 'max:255'],
            'compartimentos.*.lacre_saida_numero' => ['nullable', 'string', 'max:255'],
            'compartimentos.*.observacao' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $relatorio = $this->route('relatorio');
            $compartimentos = $this->input('compartimentos', []);

            // Security: every submitted compartimento ID must belong to this report
            foreach ($compartimentos as $index => $comp) {
                $id = $comp['id'] ?? null;
                if ($id && ! RelatorioCompartimento::where('id', $id)
                    ->where('relatorio_id', $relatorio->id)
                    ->exists()) {
                    $validator->errors()->add(
                        "compartimentos.{$index}.id",
                        'Compartimento não pertence a este relatório.'
                    );
                }
            }

            // No duplicate numero within the submitted batch
            $numeros = collect($compartimentos)->pluck('numero')->filter();
            if ($numeros->count() !== $numeros->unique()->count()) {
                $validator->errors()->add(
                    'compartimentos',
                    'Não é permitido ter dois compartimentos com o mesmo número.'
                );
            }

            // Per-compartimento: lacre_saida_numero requires lacre_entrada_numero
            foreach ($compartimentos as $index => $comp) {
                if (! empty($comp['lacre_saida_numero']) && empty($comp['lacre_entrada_numero'])) {
                    $validator->errors()->add(
                        "compartimentos.{$index}.lacre_entrada_numero",
                        'O lacre de entrada é obrigatório quando o lacre de saída é informado.'
                    );
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'data_servico.required' => 'A data do serviço é obrigatória.',
            'responsavel_tecnico_id.required' => 'O responsável técnico é obrigatório.',
            'processo.required' => 'O processo é obrigatório.',
            'lacre_entrada.required_with' => 'O lacre de entrada é obrigatório quando o lacre de saída é informado.',
            'compartimentos.required' => 'Pelo menos um compartimento é obrigatório.',
            'compartimentos.min' => 'Pelo menos um compartimento é obrigatório.',
            'compartimentos.*.numero.required' => 'O número do compartimento é obrigatório.',
            'compartimentos.*.numero.min' => 'O número do compartimento deve ser maior que zero.',
            'compartimentos.*.capacidade_litros.gt' => 'A capacidade deve ser maior que zero.',
            'compartimentos.*.tempo_minutos.min' => 'O tempo deve ser zero ou maior.',
            'compartimentos.*.pressao_vapor.min' => 'A pressão deve ser zero ou maior.',
            'compartimentos.*.massa_vapor.min' => 'A massa de vapor deve ser zero ou maior.',
            'compartimentos.*.volume_ar.min' => 'O volume de ar deve ser zero ou maior.',
        ];
    }
}
