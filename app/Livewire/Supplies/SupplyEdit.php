<?php

namespace App\Livewire\Supplies;

use App\Models\Supply;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Editar Insumo')]
class SupplyEdit extends Component
{
    public int $supplyId;

    /**
     * Mount the component with the supply id.
     */
    public function mount(Supply $supply): void
    {
        $this->supplyId = $supply->id;
    }

    /**
     * Render the supply edit page.
     */
    public function render()
    {
        return view('livewire.supplies.supply-edit');
    }
}
