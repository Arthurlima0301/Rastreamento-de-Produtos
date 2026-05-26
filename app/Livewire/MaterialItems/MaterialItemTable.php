<?php

namespace App\Livewire\MaterialItems;

use App\Models\MaterialItem;
use Livewire\Component;
use Livewire\WithPagination;

class MaterialItemTable extends Component
{
    use WithPagination;

    public string $search = '';

    public function render()
    {
        $materialItems = MaterialItem::query()
            ->with('material', 'material.order', 'materialInvoice')
            ->searchByMaterialPaper($this->search)
            ->latest()
            ->paginate(50);

        return view('livewire.material-items.material-item-table', compact('materialItems'));
    }
}
