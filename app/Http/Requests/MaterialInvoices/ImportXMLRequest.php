<?php

namespace App\Http\Requests\MaterialInvoices;

use App\Rules\MaterialInvoices\ValidXMLMaterialInvoice;
use Illuminate\Foundation\Http\FormRequest;

class ImportXMLRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /*
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'xml_file' => ['required', 'file', 'max:5120', new ValidXMLMaterialInvoice],
        ];
    }

    /*
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'xml_file.required' => 'Arquivo XML e obrigatorio.',
            'xml_file.file' => 'Envie um arquivo valido.',
            'xml_file.max' => 'O arquivo deve ter no maximo 5MB.',
        ];
    }
}
