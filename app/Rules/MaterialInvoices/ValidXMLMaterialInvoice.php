<?php

namespace App\Rules\MaterialInvoices;

use App\Models\Material;
use App\Models\MaterialInvoice;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ValidXMLMaterialInvoice implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $xml = simplexml_load_file($value->getRealPath());

        if ($xml === false) {
            $fail('O XML enviado é inválido.');

            return;
        }

        if (! isset($xml->NFe->infNFe)) {
            $fail('O XML não parece ser uma NF-e válida.');

            return;
        }

        if (! isset($xml->NFe->infNFe->ide->nNF) || ! isset($xml->NFe->infNFe->ide->dhEmi)) {
            $fail('O XML não contém os campos necessários: nNF e dhEmi.');

            return;
        }

        if (! isset($xml->NFe->infNFe->det) || count($xml->NFe->infNFe->det) == 0) {
            $fail('O XML não contém os campos necessários: det.');

            return;
        }

        if (MaterialInvoice::where('invoice_code', $xml->NFe->infNFe->ide->nNF)->exists()) {
            $fail('Nota fiscal já existe.');

            return;
        }

        foreach ($xml->NFe->infNFe->det as $materialItem) {
            $materialCode = (int) $materialItem->prod->cProd;

            if (! Material::where('shipment_code', $materialCode)->exists()) {
                $fail("O material com código {$materialCode} não existe na base de dados.");
            }
        }
    }
}
