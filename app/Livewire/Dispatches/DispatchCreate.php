<?php

namespace App\Livewire\Dispatches;

use App\Models\Dispatch;
use App\Models\ItemMaterial;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('Layout.layout')]
class DispatchCreate extends Component
{
    use WithPagination;
    public string $search = '';

    /*
    */
    public function render()
    {
        $itemMaterials = ItemMaterial::query()
            ->with(['material.order.client', 'materialInvoice'])
            ->orderBy('created_at', 'desc')
            ->searchByMaterialPaper($this->search)
            ->paginate(50);

        return view('livewire.dispatches.dispatch-create', compact('itemMaterials'));
    }

    /**
     * Redirecting to select Item Material pallets after choose Item Material
     */
    public function selectedItemMaterial(ItemMaterial $itemMaterial)
    {
        // Create Dispatch
        $dispatch = Dispatch::create([
            'dispatched_at' => now(),
            'item_material_id' =>  $itemMaterial->id,
        ]);

        return redirect()->route('dispatches.pallets', [$dispatch]);
    }
}
