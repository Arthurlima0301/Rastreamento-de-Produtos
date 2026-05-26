<?php

namespace App\Services\MaterialInvoices;

use App\Models\MaterialInvoice;
use Illuminate\Support\Facades\DB;

class ImportMaterialInvoiceFromXMLService
{
    /**
     * Import data from an XML file and save it to the database.
     */
    public function import($file)
    {
        $xml = simplexml_load_file($file->getRealPath());

        DB::transaction(function () use ($xml) {
            $materialInvoice = $this->createMaterialInvoice($xml);

            $this->importMaterialItems($xml, $materialInvoice->id);
        });
    }

    /**
     * Create material invoice.
     */
    private function createMaterialInvoice($xml): MaterialInvoice
    {
        return MaterialInvoice::create([
            'material_invoice_code' => $xml->NFe->infNFe->ide->nNF,
        ]);
    }

    /**
     * Import material items from an XML file and save them to the database.
     */
    private function importMaterialItems($xml, int $materialInvoiceId)
    {
        (new ExtractMaterialItems)->extract($xml, $materialInvoiceId);
    }
}
