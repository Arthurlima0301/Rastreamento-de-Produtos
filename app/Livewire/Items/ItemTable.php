<?php

namespace App\Livewire\Items;

use App\Models\Item;
use Livewire\Component;

class ItemTable extends Component
{
    public string $search = '';

    public function render()
    {
        $search = trim($this->search);

        $elementos = Item::with('invoice', 'supply')
            ->withSum('dispatchItems', 'quantity')
            ->when($search !== '', function ($query) use ($search) {
                $query->whereHas('supply', function ($query) use ($search) {
                    $query->where('name', 'like', $search.'%');
                });
            })
            ->get();

        return view('livewire.items.item-table', compact('elementos'));
    }
}
