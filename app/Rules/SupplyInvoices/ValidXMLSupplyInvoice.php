<?php

namespace App\Rules\SupplyInvoices;

use App\Models\Supply;
use App\Models\SupplyInvoice;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ValidXMLSupplyInvoice implements ValidationRule
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
         * Validate if the supply invoice already exists in the database before importing.
         */
        if (SupplyInvoice::where('supply_invoice_code', $xml->NFe->infNFe->ide->nNF)->exists()) {
            $fail('Nota fiscal já existe.');

            return;
        }

        /**
         * Validate supply exists in the database before saving supply items.
         */
        foreach ($xml->NFe->infNFe->det as $supplyItem) {
            $supplyCode = (int) $supplyItem->prod->cProd;

            if (! Supply::where('supply_code', $supplyCode)->exists()) {
                $fail("O insumo com código {$supplyCode} não existe na base de dados.");
            }
        }
    }
}
