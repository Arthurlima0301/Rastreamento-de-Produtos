<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsumeItemsRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'items' => 'required|array',
            'items.*.id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
        ];
    }

    /**
     * Get custom error messages for validation failures.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'items.required' => 'A lista de itens é obrigatória.',
            'items.*.id.exists' => 'O item selecionado é inválido.',
            'items.*.quantity.required' => 'A quantidade é obrigatória.',
            'items.*.quantity.numeric' => 'A quantidade deve ser um número.',
            'items.*.quantity.min' => 'A quantidade deve ser pelo menos 1.',
        ];
    }
}
