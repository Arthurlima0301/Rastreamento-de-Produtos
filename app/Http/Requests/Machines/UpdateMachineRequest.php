<?php

namespace App\Http\Requests\Machines;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMachineRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'acronym' => 'required|string|size:1',
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
            'name.required' => 'O campo nome e obrigatorio.',
            'name.max' => 'O campo nome deve ter no maximo 100 caracteres.',
            'acronym.required' => 'O campo sigla e obrigatorio.',
            'acronym.size' => 'O campo sigla deve ter exatamente 1 caractere.',
        ];
    }
}
