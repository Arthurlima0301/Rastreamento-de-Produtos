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

    public function mount(Supply $supply): void
    {
        $this->supplyId = $supply->id;
    }

    public function render()
    {
        return view('livewire.supplies.supply-edit');
    }
}
