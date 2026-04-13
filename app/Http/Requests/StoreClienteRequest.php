<?php

namespace App\Http\Requests;

use App\Enums\TipoPessoa;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tipo_pessoa' => ['required', Rule::enum(TipoPessoa::class)],
            'nome_razao_social' => ['required', 'string', 'max:255'],
            'cpf_cnpj' => [
                'required',
                'string',
                'regex:/^\d+$/',
                Rule::unique('clientes', 'cpf_cnpj'),
                function (string $attribute, mixed $value, \Closure $fail) {
                    $tipoPessoa = $this->input('tipo_pessoa');
                    if ($tipoPessoa === 'PF' && strlen($value) !== 11) {
                        $fail('O CPF deve conter exatamente 11 dígitos numéricos.');
                    }
                    if ($tipoPessoa === 'PJ' && strlen($value) !== 14) {
                        $fail('O CNPJ deve conter exatamente 14 dígitos numéricos.');
                    }
                },
            ],
            'endereco' => ['nullable', 'string', 'max:255'],
            'cidade' => ['nullable', 'string', 'max:255'],
            'estado' => ['nullable', 'string', 'size:2'],
            'telefone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'ativo' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'tipo_pessoa.required' => 'O tipo de pessoa é obrigatório.',
            'nome_razao_social.required' => 'O nome/razão social é obrigatório.',
            'cpf_cnpj.required' => 'O CPF/CNPJ é obrigatório.',
            'cpf_cnpj.unique' => 'Este CPF/CNPJ já está cadastrado.',
            'cpf_cnpj.regex' => 'O CPF/CNPJ deve conter apenas dígitos numéricos.',
            'estado.size' => 'O estado deve conter exatamente 2 caracteres.',
            'email.email' => 'O e-mail informado não é válido.',
        ];
    }
}
