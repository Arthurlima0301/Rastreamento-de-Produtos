<?php

namespace App\Livewire\Supplies;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Insumos')]
class SupplyIndex extends Component
{
    public function render()
    {
        return view('livewire.supplies.supply-index');
    }
}
