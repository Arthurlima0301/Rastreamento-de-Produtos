<?php

namespace App\Rules;

use App\Models\Invoice;
use App\Models\Supply;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ValidXMLInvoice implements ValidationRule
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

        /**
         * Validate if the XML file contains the necessary fields before importing.
         */
        if (! isset($xml->NFe->infNFe->ide->nNF) || ! isset($xml->NFe->infNFe->ide->dhEmi)) {
            $fail('O XML não contém os campos necessários: nNF e dhEmi.');

            return;
        }

        /**
         * Validate if the XML file contains the necessary fields before extracting items.
         */
        if (! isset($xml->NFe->infNFe->det) || count($xml->NFe->infNFe->det) == 0) {
            $fail('O XML não contém os campos necessários: det.');

            return;
        }

        /**
         * Validate if the invoice already exists in the database before importing.
         */
        if (Invoice::where('invoice_code', $xml->NFe->infNFe->ide->nNF)->exists()) {
            $fail('Nota fiscal já existe.');

            return;
        }

        /**
         * Validate supply exists in the database before saving items.
         */
        foreach ($xml->NFe->infNFe->det as $item) {
            $supplyCode = (int) $item->prod->cProd;

            if (! Supply::where('supply_code', $supplyCode)->exists()) {
                $fail("O insumo com código {$supplyCode} não existe na base de dados.");
            }
        }
    }
}
