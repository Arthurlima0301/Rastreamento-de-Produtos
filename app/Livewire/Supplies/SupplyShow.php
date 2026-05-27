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
    public int $supplyId;

    public function mount(Supply $supply): void
    {
        $this->supplyId = $supply->id;
    }

    public function render()
    {
        $supply = Supply::with('client')->findOrFail($this->supplyId);

        return view('livewire.supplies.supply-show', compact('supply'));
    }
}
