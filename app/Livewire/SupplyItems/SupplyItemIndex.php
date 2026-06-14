<?php

namespace App\Livewire\SupplyItems;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Itens de Insumo')]
class SupplyItemIndex extends Component
{
    /**
     * Render the supply item index page.
     */
    public function render(): View
    {
        return view('livewire.supply-items.supply-item-index');
    }
}
