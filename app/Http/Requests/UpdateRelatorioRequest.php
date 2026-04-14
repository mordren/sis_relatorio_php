<?php

namespace App\Http\Requests;

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
            'data_servico'           => ['required', 'date'],
            'responsavel_tecnico_id' => ['required', 'exists:users,id'],
            'observacoes'            => ['nullable', 'string', 'max:5000'],

            // Compartimento snapshot rows
            'compartimentos'         => ['required', 'array', 'min:1'],
            'compartimentos.*.id'    => ['required', 'integer'],
            'compartimentos.*.numero' => ['required', 'integer', 'min:1'],

            // Volume entered by user; nullable until they fill it in
            'compartimentos.*.capacidade_litros' => ['nullable', 'numeric', 'gt:0'],

            // Product: must be in the canonical catalog when provided
            'compartimentos.*.produto_anterior_nome' => [
                'nullable',
                'string',
                'max:255',
                Rule::exists('produtos_transportados', 'nome')->where('ativo', true),
            ],

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
        });
    }

    public function messages(): array
    {
        return [
            'data_servico.required'                      => 'A data do serviço é obrigatória.',
            'responsavel_tecnico_id.required'            => 'O responsável técnico é obrigatório.',
            'compartimentos.required'                    => 'Pelo menos um compartimento é obrigatório.',
            'compartimentos.min'                         => 'Pelo menos um compartimento é obrigatório.',
            'compartimentos.*.numero.required'           => 'O número do compartimento é obrigatório.',
            'compartimentos.*.numero.min'                => 'O número do compartimento deve ser maior que zero.',
            'compartimentos.*.capacidade_litros.gt'      => 'O volume deve ser maior que zero.',
            'compartimentos.*.produto_anterior_nome.exists' => 'Produto não encontrado no catálogo. Use um produto da lista.',
        ];
    }
}
