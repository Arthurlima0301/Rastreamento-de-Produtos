<?php

namespace App\Http\Requests\Invoices;

use App\Rules\Invoices\ValidXMLInvoice;
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
            'xml_file' => ['required', 'file', 'max:5120', new ValidXMLInvoice],
        ];
    }

    /*
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'xml_file.required' => 'Arquivo XML é obrigatório.',
            'xml_file.file' => 'Envie um arquivo válido.',
            'xml_file.max' => 'O arquivo deve ter no máximo 5MB.',
        ];
    }
}
