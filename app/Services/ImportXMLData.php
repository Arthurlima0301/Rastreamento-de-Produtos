<?php

namespace App\Services;

use App\Models\NotaFiscal;
use Illuminate\Support\Facades\DB;

use App\Services\ExtractItems;

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

            $notaFiscal = $this->createNotaFiscal($xml);

            $this->importItems($xml, $notaFiscal->id);
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
        if (NotaFiscal::where('codigo_nf', $xml->NFe->infNFe->ide->nNF)->exists()) {
            throw new \Exception('Nota fiscal já existe.');
        }
    }

    /**
     * Create Nota Fiscal.
     */
    private function createNotaFiscal($xml)
    {
        return NotaFiscal::create([
            'codigo_nf' => $xml->NFe->infNFe->ide->nNF,
            'data_emissao' => $xml->NFe->infNFe->ide->dhEmi,
        ]);
    }

    /**
     * Import Itens from an XML file and save them to the database. 
     */
    private function importItems($xml, $notaFiscalId)
    {
        (new ExtractItems)->extract($xml, $notaFiscalId);
    }
}
