<?php

namespace App\Livewire\Dispatches;

use App\Models\Dispatch;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Saídas')]
class DispatchShow extends Component
{
    public int $dispatchId;

    public function mount(Dispatch $dispatch): void
    {
        $this->dispatchId = $dispatch->id;
    }

    public function render()
    {
        $dispatch = Dispatch::with('items.item.supply', 'items.item.invoice')
            ->findOrFail($this->dispatchId);

        return view('livewire.dispatches.dispatch-show', compact('dispatch'));
    }
}
