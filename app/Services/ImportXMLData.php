<?php

namespace App\Services;

use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class ImportXMLData
{
    /**
     * Import data from an XML file and save it to the database.
     */
    public function import($file)
    {
        $xml = simplexml_load_file($file->getRealPath());

        DB::transaction(function () use ($xml) {
            $this->validateFields($xml);
            $this->validateAlreadyExists($xml);

            $invoice = $this->createInvoice($xml);

            $this->importItems($xml, $invoice->id);
        });
    }

    /**
     * Validate if the XML file contains the necessary fields before importing.
     */
    private function validateFields($xml)
    {
        if (!isset($xml->NFe->infNFe->ide->nNF) || !isset($xml->NFe->infNFe->ide->dhEmi)) {
            throw new \Exception('O XML não contém os campos necessários: nNF e dhEmi.');
        }
    }

    /**
     * Validate the XML file already exists.
     */
    private function validateAlreadyExists($xml)
    {
        if (Invoice::where('invoice_code', $xml->NFe->infNFe->ide->nNF)->exists()) {
            throw new \Exception('Nota fiscal já existe.');
        }
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
        (new ExtractItems())->extract($xml, $invoiceId);
    }
}
