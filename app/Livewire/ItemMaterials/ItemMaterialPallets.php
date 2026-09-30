<?php

namespace App\Livewire\ItemMaterials;

use App\Models\ItemMaterial;
use App\Models\Pallet;
use Livewire\Component;
use Livewire\WithPagination;

class ItemMaterialPallets extends Component
{
    public ItemMaterial $itemMaterial;
    public string $search = '';


    use WithPagination;

    public function render()
    {
        $pallets = Pallet::query()
            ->where('item_material_id', $this->itemMaterial->id)
            ->with('cutLoad.machine')
            ->searchByLabelOrMaterial($this->search)
            ->paginate(50);

        return view('livewire.item-materials.item-material-pallets',compact('pallets'));
    }
}
