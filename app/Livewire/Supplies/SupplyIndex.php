<?php

namespace App\Livewire\Supplies;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Insumos')]
class SupplyIndex extends Component
{
    /**
     * Render the supply index page.
     */
    public function render(): View
    {
        return view('livewire.supplies.supply-index');
    }
}
