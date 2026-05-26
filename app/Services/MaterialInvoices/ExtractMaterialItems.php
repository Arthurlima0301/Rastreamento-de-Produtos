<?php

namespace App\Services\MaterialInvoices;

use App\Models\Material;
use App\Models\MaterialItem;

class ExtractMaterialItems
{
    /**
     * Extract material items from an XML file and save them to the database.
     */
    public function extract($xml, $materialInvoiceId)
    {
        $materialItems = [];
        foreach ($xml->NFe->infNFe->det as $materialItem) {
            $materialItems[] = $materialItem;
        }

        $this->saveMaterialItems($materialItems, $materialInvoiceId);
    }

    /**
     * Save material items to the database.
     */
    private function saveMaterialItems(array $materialItems, int $materialInvoiceId)
    {
        foreach ($materialItems as $materialItem) {
            $material = Material::where('shipping_code', (int) $materialItem->prod->cProd)->first();

            MaterialItem::create([
                'material_invoice_id' => $materialInvoiceId,
                'material_id' => $material->id,
                'roll_quantity' => $materialItem->prod->qCom,
                'weight' => $material->net_weight_p,
            ]);
        }
    }
}
