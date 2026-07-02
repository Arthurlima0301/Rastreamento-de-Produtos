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

    /**
     * Render the component view.
     */
    public function render()
    {
        $loads = Load::whereHas('rolls', function ($query) {
            $query->where('item_material_id', $this->itemMaterial->id);
        })
        ->with('machine')
        ->withSum(['rolls as total_rolls_weight' => function ($query) {
            $query->where('item_material_id', $this->itemMaterial->id);
        }], 'weight')
        ->withSum(['pallets as total_pallets_weight' => function ($query) {
            $query->where('item_material_id', $this->itemMaterial->id);
        }], 'package_net_weight')
        ->withCount('rolls as total_rolls')
        ->withCount('pallets as total_pallets')
        ->paginate(50);

        return view('livewire.item-materials.item-material-loads', compact('loads'));
    }
}
