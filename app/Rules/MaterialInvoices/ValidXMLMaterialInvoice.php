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
            $fail('O XML enviado e invalido.');

            return;
        }

        if (! isset($xml->NFe->infNFe)) {
            $fail('O XML nao parece ser uma NF-e valida.');

            return;
        }

        if (! isset($xml->NFe->infNFe->ide->nNF)) {
            $fail('O XML nao contem o campo necessario: nNF.');

            return;
        }

        if (! isset($xml->NFe->infNFe->det) || count($xml->NFe->infNFe->det) == 0) {
            $fail('O XML nao contem os campos necessarios: det.');

            return;
        }

        if (MaterialInvoice::where('material_invoice_code', $xml->NFe->infNFe->ide->nNF)->exists()) {
            $fail('Nota fiscal de material ja existe.');

            return;
        }

        foreach ($xml->NFe->infNFe->det as $materialItem) {
            $shippingCode = (int) $materialItem->prod->cProd;

            if (! Material::where('shipping_code', $shippingCode)->exists()) {
                $fail("O material com codigo de envio {$shippingCode} nao existe na base de dados.");
            }
        }
    }
}
