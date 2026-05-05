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
        $items = [];
        foreach ($xml->NFe->infNFe->det as $item) {
            $items[] = $item;
        }

        $this->saveItems($items, $invoiceId);
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
