<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInsumoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $insumoId = $this->route('insumo')?->id ?? $this->insumo;
        return [
            'codigo_insumo' => 'required|string|unique:insumos,codigo_insumo,' . $insumoId,
            'nome' => 'required|string',
            'unidade_medida' => 'required|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'codigo_insumo.required' => 'O campo código do insumo é obrigatório.',
            'codigo_insumo.unique' => 'O código do insumo já existe. Por favor, escolha outro.',
            'nome.required' => 'O campo nome é obrigatório.',
            'unidade_medida.required' => 'O campo unidade de medida é obrigatório.',
            'unidade_medida.string' => 'O campo unidade de medida deve ser uma string.',
        ];
    }
}
