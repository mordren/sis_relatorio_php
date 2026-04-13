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
        ];
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
        ];
    }
}
