<?php

namespace App\Services\Invoices;

use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class ImportInvoiceFromXMLService
{
    /**
     * Import data from an XML file and save it to the database.
     */
    public function import($file)
    {
        $xml = simplexml_load_file($file->getRealPath());

        DB::transaction(function () use ($xml) {
            $invoice = $this->createInvoice($xml);

            $this->importItems($xml, $invoice->id);
        });
    }

    /**
     * Create Invoice.
     */
    private function createInvoice($xml): Invoice
    {
        return Invoice::create([
            'invoice_code' => $xml->NFe->infNFe->ide->nNF,
            'issued_at' => $xml->NFe->infNFe->ide->dhEmi,
        ]);
    }

    /**
     * Import items from an XML file and save them to the database.
     */
    private function importItems($xml, int $invoiceId)
    {
        (new ExtractItems)->extract($xml, $invoiceId);
    }
}
