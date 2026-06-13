<?php

namespace App\Livewire\Dispatches;

use App\Models\Dispatch;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Detalhes da Saída')]
class DispatchShow extends Component
{
    public int $dispatchId;

    /**
     * Mount the component with the dispatch id.
     */
    public function mount(Dispatch $dispatch): void
    {
        $this->dispatchId = $dispatch->id;
    }

    /**
     * Render the dispatch detail page.
     */
    public function render()
    {
        $dispatch = Dispatch::with('dispatchItems.supplyItem.supply', 'dispatchItems.supplyItem.supplyInvoice')
            ->findOrFail($this->dispatchId);

        return view('livewire.dispatches.dispatch-show', compact('dispatch'));
    }
}
