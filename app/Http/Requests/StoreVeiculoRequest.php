<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVeiculoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'placa' => [
                'required',
                'string',
                'max:10',
                Rule::unique('veiculos', 'placa'),
            ],
            'modelo' => ['required', 'string', 'max:255'],
            'marca' => ['required', 'string', 'max:255'],
            'ano' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 2)],
            'tipo_veiculo' => ['nullable', 'string', 'max:255'],
            'proprietario_id' => ['nullable', 'exists:clientes,id'],
            'ativo' => ['boolean'],

            // Compartments – at least one required
            'compartimentos' => ['required', 'array', 'min:1'],
            'compartimentos.*.numero' => ['required', 'integer', 'min:1'],
            'compartimentos.*.capacidade_litros' => ['required', 'numeric', 'gt:0'],
            'compartimentos.*.produto_atual_id' => ['nullable', 'exists:produtos_transportados,id'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($v) {
            $numeros = collect($this->input('compartimentos', []))
                ->pluck('numero')
                ->filter();

            if ($numeros->count() !== $numeros->unique()->count()) {
                $v->errors()->add(
                    'compartimentos',
                    'Não é permitido repetir o número de compartimento no mesmo veículo.'
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            'placa.required' => 'A placa é obrigatória.',
            'placa.unique' => 'Esta placa já está cadastrada.',
            'modelo.required' => 'O modelo é obrigatório.',
            'marca.required' => 'A marca é obrigatória.',
            'ano.integer' => 'O ano deve ser um número inteiro.',
            'proprietario_id.exists' => 'O proprietário selecionado não existe.',
            'compartimentos.required' => 'Pelo menos um compartimento é obrigatório.',
            'compartimentos.min' => 'Pelo menos um compartimento é obrigatório.',
            'compartimentos.*.numero.required' => 'O número do compartimento é obrigatório.',
            'compartimentos.*.numero.min' => 'O número do compartimento deve ser maior ou igual a 1.',
            'compartimentos.*.capacidade_litros.required' => 'A capacidade do compartimento é obrigatória.',
            'compartimentos.*.capacidade_litros.gt' => 'A capacidade deve ser maior que zero.',
        ];
    }
}
