<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplyRequest extends FormRequest
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
        return [
            'supply_code' => 'required|string|unique:supplies,supply_code',
            'name' => 'required|string',
            'unit_of_measure' => 'required|string',
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
            'supply_code.required' => 'O campo código do insumo é obrigatório.',
            'supply_code.unique' => 'O código do insumo já existe. Por favor, escolha outro.',
            'name.required' => 'O campo nome é obrigatório.',
            'unit_of_measure.required' => 'O campo unidade de medida é obrigatório.',
            'unit_of_measure.string' => 'O campo unidade de medida deve ser uma string.',
        ];
    }
}
