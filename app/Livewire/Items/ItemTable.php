<?php

namespace App\Livewire\Items;

use App\Models\Item;
use Livewire\Component;
use Livewire\WithPagination;

class ItemTable extends Component
{
    use WithPagination;

    public string $search = '';
    
    public bool $available = false; 


    public function render()
    {

        $items = Item::withBalance()
            ->filterBalance($this->available)
            ->searchBySupplyName($this->search)
            ->paginate(50);

        return view('livewire.items.item-table', compact('items'));
    }
}
