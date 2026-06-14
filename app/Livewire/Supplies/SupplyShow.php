<?php

namespace App\Livewire\Supplies;

use App\Models\Supply;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Detalhes do Insumo')]
class SupplyShow extends Component
{
    public Supply $supply;

    /**
     * Mount the component with the supply id.
     */
    public function mount(Supply $supply): void
    {
        $this->supply = $supply;
    }

    /**
     * Render the supply detail page.
     */
    public function render()
    {
        $supply = $this->supply->load('client', 'supplyItems');

        return view('livewire.supplies.supply-show', compact('supply'));
    }
}
