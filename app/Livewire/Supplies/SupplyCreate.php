<?php

namespace App\Livewire\Supplies;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Criar Insumo')]
class SupplyCreate extends Component
{
    /**
     * Render the supply creation page.
     */
    public function render(): View
    {
        return view('livewire.supplies.supply-create');
    }
}
