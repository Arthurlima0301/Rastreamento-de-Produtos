<?php

namespace App\Livewire\Dispatches;

use App\Models\Dispatch;
use Livewire\Component;

class DispatchShowSupplies extends Component
{
    public int $dispatchId;

    /**
     * Mount the component with the dispatch id.
     */
    public function mount($dispatchId): void
    {
        $this->dispatchId = $dispatchId;
    }


    public function render()
    {
        $dispatch = Dispatch::with('dispatchItems.supplyItem.supply', 'dispatchItems.supplyItem.supplyInvoice')
            ->findOrFail($this->dispatchId);

        return view('livewire.dispatches.dispatch-show-supplies', compact('dispatch'));
    }


}
