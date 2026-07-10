<?php

namespace App\Livewire\ItemMaterials;

use App\Models\ItemMaterial;
use App\Models\Load;
use Livewire\Component;

class ItemMaterialLoads extends Component
{
    public ItemMaterial $itemMaterial;

    /**
     * 
     */
    public function mount(ItemMaterial $itemMaterial)
    {
        $this->itemMaterial = $itemMaterial;
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        $loads = Load::query()
        ->with('machine')
        ->withSum(['rolls as total_rolls_weight' => fn ($q) => $q->where('item_material_id', $this->itemMaterial->id)], 'weight')
        ->withSum(['pallets as total_pallets_weight' => fn ($q) => $q->where('item_material_id', $this->itemMaterial->id)], 'package_net_weight')
        ->withCount(['rolls as total_rolls' => fn ($q) => $q->where('item_material_id', $this->itemMaterial->id)])
        ->withCount(['pallets as total_pallets' => fn ($q) => $q->where('item_material_id', $this->itemMaterial->id)])
        ->whereHas('rolls', function ($q) {
            $q->where('item_material_id', $this->itemMaterial->id);
        })
        ->paginate(50);

        return view('livewire.item-materials.item-material-loads', compact('loads'));
    }
}
