<?php

namespace App\Services\SupplyInvoices;

use App\Models\SupplyInvoice;
use Illuminate\Support\Facades\DB;

class ImportSupplyInvoiceFromXMLService
{
    /**
     * Import data from an XML file and save it to the database.
     */
    public function import($file)
    {
        $xml = simplexml_load_file($file->getRealPath());

        DB::transaction(function () use ($xml) {
            $supplyInvoice = $this->createSupplyInvoice($xml);

            $this->importSupplyItems($xml, $supplyInvoice->id);
        });
    }

    /**
     * Create supply invoice.
     */
    private function createSupplyInvoice($xml): SupplyInvoice
    {
        return SupplyInvoice::create([
            'supply_invoice_code' => $xml->NFe->infNFe->ide->nNF,
            'issued_at' => $xml->NFe->infNFe->ide->dhEmi,
        ]);
    }

    /**
     * Import supply items from an XML file and save them to the database.
     */
    private function importSupplyItems($xml, int $supplyInvoiceId)
    {
        (new ExtractSupplyItems)->extract($xml, $supplyInvoiceId);
    }
}
