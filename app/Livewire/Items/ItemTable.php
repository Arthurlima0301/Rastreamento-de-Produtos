<?php

namespace App\Livewire\Items;

use App\Models\Item;
use Livewire\Component;
use Livewire\WithPagination;

class ItemTable extends Component
{
    use WithPagination;

    public string $search = '';

    public function render()
    {
        $items = Item::with('invoice', 'supply')
            ->withSum('dispatchItems', 'quantity')
            ->searchBySupplyName($this->search)
            ->paginate(50);

        return view('livewire.items.item-table', compact('items'));
    }
}
