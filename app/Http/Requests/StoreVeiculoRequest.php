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
            'tipo_veiculo' => ['required', Rule::in(['SEMIRREBOQUE', 'CAMINHAO', 'REBOCADO'])],
            'numero_equipamento' => ['nullable', 'string', 'max:50'],
            'numero_compartimentos' => ['required', 'integer', 'min:1', 'max:99'],
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
            'tipo_veiculo.required' => 'O tipo de veículo é obrigatório.',
            'tipo_veiculo.in' => 'Tipo de veículo inválido. Use: SEMIRREBOQUE, CAMINHAO ou REBOCADO.',
            'numero_compartimentos.required' => 'O número de compartimentos é obrigatório.',
            'numero_compartimentos.integer' => 'O número de compartimentos deve ser inteiro.',
            'numero_compartimentos.min' => 'O veículo deve ter pelo menos 1 compartimento.',
            'numero_compartimentos.max' => 'O número máximo de compartimentos é 99.',
            'proprietario_id.exists' => 'O proprietário selecionado não existe.',
        ];
    }
}
