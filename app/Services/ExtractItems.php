<?php

namespace App\Services;

use App\Models\Item;
use App\Models\Insumo;

class ExtractItems
{
    /**
     * Extract items from an XML file and save them to the database.
     */
    public function extract($xml, $notaFiscalId)
    {
        $this->validateFields($xml);

        $items = [];
        foreach ($xml->NFe->infNFe->det as $item) {
            $items[] = $item;
        }

        $this->validateInsumos($items);

        $this->saveItems($items, $notaFiscalId);
    }

    /**
     * Validate if the XML file contains the necessary fields before extracting items.
     */
    private function validateFields($xml)
    {
        if (!isset($xml->NFe->infNFe->det) || count($xml->NFe->infNFe->det) == 0) {
            throw new \Exception('O XML não contém os campos necessários: det.');
        }
    }

    /*
    * Validate insumo exists in the database before saving items.
    */
    private function validateInsumos($items)
    {
        foreach ($items as $item) {
            $insumoCod = (int) $item->prod->cProd;
            if (!Insumo::where('codigo_insumo', $insumoCod)->exists()) {
                throw new \Exception("O insumo com código {$insumoCod} não existe na base de dados.");
            }
        }
    }

    /**
     * Save items to the database.
     */
    private function saveItems($items, $notaFiscalId)
    {
        foreach ($items as $item) {
            // converter o codigo do insumo para o id do insumo
            
            $insumo = Insumo::where('codigo_insumo', (int) $item->prod->cProd)->first();
            
            Item::create([
                'numero' => $item->nItem,
                'nota_fiscal_id' => $notaFiscalId,
                'insumo_id' => $insumo->id,
                'quantidade' => $item->prod->qCom,
            ]);
        }
    }
}
