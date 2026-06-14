<?php

namespace App\Livewire\ItemMaterials;

use App\Models\ItemMaterial;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ItemMaterialTable extends Component
{
    use WithPagination;

    public string $search = '';

    /**
     * Render the paginated item material table.
     */
    public function render(): View
    {
        $itemMaterials = ItemMaterial::query()
            ->with(['material.order.client', 'materialInvoice'])
            ->orderBy('created_at', 'desc')
            ->searchByMaterialPaper($this->search)
            ->paginate(50);

        return view('livewire.item-materials.item-material-table', compact('itemMaterials'));
    }
}
