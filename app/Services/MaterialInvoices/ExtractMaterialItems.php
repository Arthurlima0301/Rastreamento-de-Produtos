<?php

namespace App\Services\MaterialInvoices;

use App\Models\ItemMaterial;
use App\Models\Material;

class ExtractMaterialItems
{
    public function extract($xml, $materialInvoiceId): void
    {
        $materialItems = [];

        foreach ($xml->NFe->infNFe->det as $materialItem) {
            $materialItems[] = $materialItem;
        }

        $this->saveMaterialItems($materialItems, $materialInvoiceId);
    }

    private function saveMaterialItems(array $materialItems, int $materialInvoiceId): void
    {
        foreach ($materialItems as $materialItem) {
            $material = Material::where('shipment_code', (int) $materialItem->prod->cProd)->first();

            ItemMaterial::create([
                'number' => $materialItem['nItem'] ?? $materialItem->nItem,
                'material_invoice_id' => $materialInvoiceId,
                'material_id' => $material->id,
                'total_weight' => (float) ($materialItem->prod->qCom ?? 0),
            ]);
        }
    }
}
