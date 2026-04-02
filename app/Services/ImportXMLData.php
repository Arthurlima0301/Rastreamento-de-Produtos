<?php

namespace App\Services;

use App\Models\NotaFiscal;
use Illuminate\Support\Facades\DB;

class ImportXMLData
{
    public function import($file)
    {
    
        $xml = simplexml_load_file($file->getRealPath());

        DB::transaction(function () use ($xml) {
            if (NotaFiscal::where('codigo_nf', $xml->infNFe->ide->cNF)->exists()) {
                throw new \Exception('Nota fiscal já existe.');
            }

            if (!isset($xml->infNFe->ide->cNF) || !isset($xml->infNFe->ide->dhEmi)) {
                throw new \Exception('O XML não contém os campos necessários: cNF ou dhEmi.');
            }
        
            NotaFiscal::create([
                'codigo_nf' => $xml->infNFe->ide->cNF,
                'data_emissao' => $xml->infNFe->ide->dhEmi,
            ]);
        });

    }
}
