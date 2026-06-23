<?php


namespace App\Services\ItemMaterials;

use App\Models\ItemMaterial;


class PackingCalculator
{

    /**
     * Calculate the waste quantity based on the total weight of the item material and the total weight of the pallets.
     */
    public function calculateWaste(ItemMaterial $itemMaterial, int $palletQuantity): float
    {
        $totalPalletWeight = $itemMaterial->material->package_net_weight * $palletQuantity;
        return floatval($itemMaterial->total_weight - $totalPalletWeight);
    }

    /**
     * Calculate the loss percentage based on the total weight of the pallets and the initial total weight of the item material.
     */
    public function calculateLoss(ItemMaterial $itemMaterial, int $palletQuantity): float
    {
        $totalPalletWeight = $itemMaterial->material->package_net_weight * $palletQuantity;
        return floatval((($itemMaterial->total_weight - $totalPalletWeight) / $itemMaterial->total_weight) * 100);
    }
}
