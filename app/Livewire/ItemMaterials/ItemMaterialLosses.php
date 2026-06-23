<?php

namespace App\Livewire\ItemMaterials;

use App\Models\ItemMaterial;
use App\Services\ItemMaterials\PackingCalculator;
use Livewire\Component;

class ItemMaterialLosses extends Component
{
    public ItemMaterial $itemMaterial;

    public int $palletQuantity;
    public float $lossPercentage;
    public float $wasteQuantity;

    /**
     * Mount the component with the initial total weight of the item material and the weight of the pallet.
     */
    public function mount(ItemMaterial $itemMaterial)
    {
        $this->itemMaterial = $itemMaterial;

        $this->palletQuantity = $this->itemMaterial->pallets_quantity ?? 0;
        $this->calc(new PackingCalculator());
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.item-materials.item-material-losses');
    }

    /**
     * Calculate the loss percentage based on the total weight of the pallets and the initial total weight of the item material.
     */
    public function calc(PackingCalculator $packingCalculator)
    {
        $this->validate(
            [
                'palletQuantity' => 'required|numeric|min:0',
            ],
            [
                'palletQuantity.required' => 'A quantidade de pallets é obrigatória.',
                'palletQuantity.numeric' => 'A quantidade de pallets deve ser um número.',
                'palletQuantity.min' => 'A quantidade de pallets não pode ser negativa.',
            ]
        );

        $this->wasteQuantity = $packingCalculator->calculateWaste($this->itemMaterial, $this->palletQuantity);
        $this->lossPercentage = $packingCalculator->calculateLoss($this->itemMaterial, $this->palletQuantity);

        $this->itemMaterial->update([
            'pallets_quantity' => $this->palletQuantity,
        ]);
    }
}
