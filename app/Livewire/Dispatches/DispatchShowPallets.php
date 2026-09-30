<?php

namespace App\Livewire\Dispatches;

use App\Models\Pallet;
use Livewire\Component;

class DispatchShowPallets extends Component
{
    public string $search = '';
    public int $dispatchId;

    /**
     * Mount the component with the dispatch id.
     */
    public function mount($dispatchId): void
    {
        $this->dispatchId = $dispatchId;
    }

    /**
     * 
     */
    public function render()
    {
        $pallets = Pallet::query()
            ->where('dispatch_id', $this->dispatchId)
            ->searchByLabelOrMaterial($this->search)
            ->paginate(50);

        return view('livewire.dispatches.dispatch-show-pallets', compact('pallets'));
    }


}
