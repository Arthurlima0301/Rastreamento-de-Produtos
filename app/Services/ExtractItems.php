<?php

namespace App\Services;

use App\Models\Item;
use App\Models\Supply;

class ExtractItems
{
    /**
     * Extract items from an XML file and save them to the database.
     */
    public function extract($xml, $invoiceId)
    {
        $this->validateFields($xml);

        $items = [];
        foreach ($xml->NFe->infNFe->det as $item) {
            $items[] = $item;
        }

        $this->validateSupplies($items);

        $this->saveItems($items, $invoiceId);
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

    /**
     * Validate supply exists in the database before saving items.
     */
    private function validateSupplies(array $items)
    {
        foreach ($items as $item) {
            $supplyCode = (int) $item->prod->cProd;

            if (!Supply::where('supply_code', $supplyCode)->exists()) {
                throw new \Exception("O insumo com código {$supplyCode} não existe na base de dados.");
            }
        }
    }

    /**
     * Save items to the database.
     */
    private function saveItems(array $items, int $invoiceId)
    {
        foreach ($items as $item) {
            $supply = Supply::where('supply_code', (int) $item->prod->cProd)->first();

            Item::create([
                'number' => $item['nItem'] ?? $item->nItem,
                'invoice_id' => $invoiceId,
                'supply_id' => $supply->id,
                'quantity' => $item->prod->qCom,
            ]);
        }
    }
}
