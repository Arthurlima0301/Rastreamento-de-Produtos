<?php

namespace App\Services\Pallets;

use App\Models\ItemMaterial;
use App\Models\Load;
use App\Models\Pallet;
use Illuminate\Support\Facades\DB;

class GeneratePallets
{
    /**
     * Generate pallets for the given item material.
     */
    public function execute(ItemMaterial $itemMaterial)
    {
        $maxPallets = $itemMaterial->pallets_quantity;
        $count = $itemMaterial->pallets()->count();

        while (($load = $this->findNextAvailableLoad($itemMaterial)) && $count < $maxPallets) {
            
            DB::transaction(function () use ($itemMaterial, $load) {
                $this->generatePallet($itemMaterial, $load);
            });

            $count++;
        }
        
    }

    /*
    * Find the next available load with sufficient balance.
     */
    private function findNextAvailableLoad(ItemMaterial $itemMaterial): ?Load
    {
        return Load::withSufficientBalance($itemMaterial->id, $itemMaterial->material->package_net_weight)
            ->first();
    }

    /**
     * Generate pallet.
     */
    private function generatePallet(ItemMaterial $itemMaterial, Load $load): Pallet
    {
        return Pallet::create([
            'label' => $this->getNextPalletLabel($itemMaterial),
            'item_material_id' => $itemMaterial->id,
            'load_id' => $load->id,
            'package_net_weight' => $itemMaterial->material->package_net_weight,
        ]);
    }

    /**
     * Get the next pallet label for the given item material.
     */
    private function getNextPalletLabel(ItemMaterial $itemMaterial): int
    {
        $maxLabel = Pallet::whereHas('itemMaterial', function ($query) use ($itemMaterial) {
            $query->where('material_id', $itemMaterial->material_id);
        })->max('label');

        return $maxLabel + 1;
    }
}
