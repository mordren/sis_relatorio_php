<?php

namespace App\Http\Requests;

use App\Models\Veiculo;
use Illuminate\Foundation\Http\FormRequest;

class StoreRelatorioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'data_servico'            => ['required', 'date'],
            'responsavel_tecnico_id'  => ['required', 'exists:users,id'],
            'cliente_id'              => ['required', 'exists:clientes,id'],
            'veiculo_id'              => ['required', 'exists:veiculos,id'],
            'observacoes'             => ['nullable', 'string', 'max:5000'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $clienteId = $this->input('cliente_id');
            $veiculoId = $this->input('veiculo_id');

            if ($clienteId && $veiculoId) {
                $belongs = Veiculo::where('id', $veiculoId)
                    ->where('proprietario_id', $clienteId)
                    ->where('ativo', true)
                    ->exists();

                if (! $belongs) {
                    $validator->errors()->add(
                        'veiculo_id',
                        'O veículo selecionado não pertence ao cliente selecionado.'
                    );
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'data_servico.required'           => 'A data do serviço é obrigatória.',
            'responsavel_tecnico_id.required' => 'O responsável técnico é obrigatório.',
            'cliente_id.required'             => 'O cliente é obrigatório.',
            'cliente_id.exists'               => 'O cliente selecionado não existe.',
            'veiculo_id.required'             => 'O veículo é obrigatório.',
            'veiculo_id.exists'               => 'O veículo selecionado não existe.',
        ];
    }
}
