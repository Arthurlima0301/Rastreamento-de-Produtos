<?php

namespace App\Services\MaterialInvoices;

use App\Models\MaterialInvoice;
use Illuminate\Support\Facades\DB;

class ImportMaterialInvoiceFromXMLService
{
    public function import($file)
    {
        $xml = simplexml_load_file($file->getRealPath());

        DB::transaction(function () use ($xml) {
            $materialInvoice = $this->createMaterialInvoice($xml);

            $this->importMaterialItems($xml, $materialInvoice->id);
        });
    }

    private function createMaterialInvoice($xml): MaterialInvoice
    {
        return MaterialInvoice::create([
            'invoice_code' => $xml->NFe->infNFe->ide->nNF,
            'issued_at' => $xml->NFe->infNFe->ide->dhEmi,
        ]);
    }

    private function importMaterialItems($xml, int $materialInvoiceId): void
    {
        (new ExtractMaterialItems)->extract($xml, $materialInvoiceId);
    }
}
