<?php

namespace App\Livewire\ItemMaterials;

use App\Models\ItemMaterial;
use Livewire\Component;
use Livewire\WithPagination;

class ItemMaterialTable extends Component
{
    use WithPagination;

    public string $search = '';

    public function render()
    {
        $itemMaterials = ItemMaterial::query()
            ->with(['material.order.client', 'materialInvoice'])
            ->orderBy('created_at', 'desc')
            ->searchByMaterialPaper($this->search)
            ->paginate(50);

        return view('livewire.item-materials.item-material-table', compact('itemMaterials'));
    }
}
