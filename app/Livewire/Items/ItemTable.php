<?php

namespace App\Livewire\Items;

use App\Models\Item;
use Livewire\Component;

class ItemTable extends Component
{
    public string $search = '';

    public function render()
    {
        $items = Item::with('invoice', 'supply')
            ->withSum('dispatchItems', 'quantity')
            ->searchBySupplyName($this->search)
            ->get();

        return view('livewire.items.item-table', compact('items'));
    }
}
