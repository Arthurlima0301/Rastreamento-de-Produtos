<?php

namespace App\Livewire\SupplyItems;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Itens de Insumo')]
class SupplyItemIndex extends Component
{
    public function render()
    {
        return view('livewire.supply-items.supply-item-index');
    }
}
