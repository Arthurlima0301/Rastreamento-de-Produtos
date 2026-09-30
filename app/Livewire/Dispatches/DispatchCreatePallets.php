<?php

namespace App\Livewire\Dispatches;

use App\Models\Dispatch;
use App\Models\ItemMaterial;
use App\Models\Pallet;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('Layout.layout')]
class DispatchCreatePallets extends Component
{
    public Dispatch $dispatch;
    public string $search = '';

    /*
    *
    */
    public function mount(Dispatch $dispatch)
    {
        $this->dispatch = $dispatch;
    }

    /**
     * Render pallets that reference the selected Item Material  
     */
    public function render()
    {
        $pallets = Pallet::query()
            ->where('item_material_id', $this->dispatch->item_material_id)
            ->where('dispatch_id', $this->dispatch->id)
            ->Orwhere('dispatch_id', null)
            ->searchByLabelOrMaterial($this->search)
            ->paginate(50);

        return view('livewire.dispatches.dispatch-create-pallets', compact('pallets'));
    }

    /**
     * Add selected Pallet in dispatch 
     */
    public function addPallet(Pallet $pallet)
    {
        $pallet->update([
            'dispatch_id' => $this->dispatch->id
        ]);
    }
}
