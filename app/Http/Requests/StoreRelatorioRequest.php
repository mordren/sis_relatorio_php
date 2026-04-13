<?php

namespace App\Http\Requests;

use App\Enums\FinalidadeRelatorio;
use App\Enums\ProcessoRelatorio;
use App\Enums\StatusRelatorio;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRelatorioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'numero_relatorio' => [
                'required',
                'string',
                'max:50',
                Rule::unique('relatorio_descontaminacoes', 'numero_relatorio'),
            ],
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

            // Client selection for snapshot
            'cliente_id' => ['required', 'exists:clientes,id'],

            // Vehicle selection for snapshot
            'veiculo_id' => ['required', 'exists:veiculos,id'],

            // Finalidades
            'finalidades' => ['required', 'array', 'min:1'],
            'finalidades.*.finalidade' => [
                'required',
                Rule::enum(FinalidadeRelatorio::class),
            ],
            'finalidades.*.descricao_outros' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $finalidades = $this->input('finalidades', []);

            // Check duplicate finalidades
            $values = collect($finalidades)->pluck('finalidade')->filter();
            if ($values->count() !== $values->unique()->count()) {
                $validator->errors()->add('finalidades', 'Não é permitido repetir a mesma finalidade.');
            }

            // If OUTROS, descricao_outros is required
            foreach ($finalidades as $index => $item) {
                if (($item['finalidade'] ?? '') === FinalidadeRelatorio::OUTROS->value
                    && empty($item['descricao_outros'])) {
                    $validator->errors()->add(
                        "finalidades.{$index}.descricao_outros",
                        'A descrição é obrigatória quando a finalidade é "Outros".'
                    );
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'numero_relatorio.required' => 'O número do relatório é obrigatório.',
            'numero_relatorio.unique' => 'Este número de relatório já existe.',
            'data_servico.required' => 'A data do serviço é obrigatória.',
            'responsavel_tecnico_id.required' => 'O responsável técnico é obrigatório.',
            'processo.required' => 'O processo é obrigatório.',
            'lacre_entrada.required_with' => 'O lacre de entrada é obrigatório quando o lacre de saída é informado.',
            'cliente_id.required' => 'O cliente é obrigatório.',
            'cliente_id.exists' => 'O cliente selecionado não existe.',
            'veiculo_id.required' => 'O veículo é obrigatório.',
            'veiculo_id.exists' => 'O veículo selecionado não existe.',
            'finalidades.required' => 'Pelo menos uma finalidade é obrigatória.',
            'finalidades.min' => 'Pelo menos uma finalidade é obrigatória.',
        ];
    }
}
