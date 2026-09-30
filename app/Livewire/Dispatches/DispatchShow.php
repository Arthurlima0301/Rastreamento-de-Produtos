<?php

namespace App\Livewire\Dispatches;

use App\Models\Dispatch;
use App\Models\ItemMaterial;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Detalhes da Saída')]
class DispatchShow extends Component
{
    public Dispatch $dispatch;
    public string $tab = 'pallets';

    /**
     * Mount the component with the dispatch id.
     */
    public function mount(Dispatch $dispatch): void
    {
        $this->dispatch = $dispatch;
    }

    /**
     * Render the dispatch detail page.
     */
    public function render(): View
    {
        return view('livewire.dispatches.dispatch-show');
    }


    public function toggleTab($tab)
    {
        $this->tab = $tab;
    }
}
