<?php

namespace App\Services\MaterialInvoices;

use App\Models\ItemMaterial;
use App\Models\Material;

class ExtractMaterialItems
{
    /**
     * Extract material items from the XML invoice.
     */
    public function extract($xml, $materialInvoiceId): void
    {
        $materialItems = [];

        foreach ($xml->NFe->infNFe->det as $materialItem) {
            $materialItems[] = $materialItem;
        }

        $this->saveMaterialItems($materialItems, $materialInvoiceId);
    }

    /**
     * Save extracted material items using the material from the latest registered order.
     */
    private function saveMaterialItems(array $materialItems, int $materialInvoiceId): void
    {
        foreach ($materialItems as $materialItem) {
            $material = Material::query()
                ->select('materials.id')
                ->join('orders', 'orders.id', '=', 'materials.order_id')
                ->orderBy('orders.created_at', 'desc')
                ->where('orders.status', 'ATIVA')
                ->where('materials.shipment_code', (int) $materialItem->prod->cProd)
                ->first();

            ItemMaterial::create([
                'number' => $materialItem['nItem'] ?? $materialItem->nItem,
                'material_invoice_id' => $materialInvoiceId,
                'material_id' => $material->id,
                'total_weight' => (float) ($materialItem->prod->qCom ?? 0),
            ]);
        }
    }
}
