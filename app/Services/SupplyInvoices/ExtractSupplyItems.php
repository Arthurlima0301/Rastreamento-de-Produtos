<?php

namespace App\Services\SupplyInvoices;

use App\Models\Supply;
use App\Models\SupplyItem;

class ExtractSupplyItems
{
    /**
     * Extract supply items from an XML file and save them to the database.
     */
    public function extract($xml, $supplyInvoiceId)
    {
        $supplyItems = [];
        foreach ($xml->NFe->infNFe->det as $supplyItem) {
            $supplyItems[] = $supplyItem;
        }

        $this->saveSupplyItems($supplyItems, $supplyInvoiceId);
    }

    /**
     * Save supply items to the database.
     */
    private function saveSupplyItems(array $supplyItems, int $supplyInvoiceId)
    {
        foreach ($supplyItems as $supplyItem) {
            $supply = Supply::where('supply_code', (int) $supplyItem->prod->cProd)->first();

            SupplyItem::create([
                'number' => $supplyItem['nItem'] ?? $supplyItem->nItem,
                'supply_invoice_id' => $supplyInvoiceId,
                'supply_id' => $supply->id,
                'quantity' => $supplyItem->prod->qCom,
            ]);
        }
    }
}
