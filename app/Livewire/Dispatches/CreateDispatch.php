<?php

namespace App\Livewire\Dispatches;

use App\Models\Item;
use Livewire\Component;

class CreateDispatch extends Component
{
    public string $search = '';

    public array $selectedItems = [];

    public function render()
    {
        $items = Item::with('invoice', 'supply')
            ->withSum('dispatchItems', 'quantity')
            ->searchBySupplyName($this->search)
            ->get();

        return view('livewire.dispatches.create-dispatch', compact('items'));
    }

    public function selectItem($itemId)
    {
        if (isset($this->selectedItems[$itemId])) {
            unset($this->selectedItems[$itemId]);

            return;
        }

        $item = Item::with('supply')->find($itemId);

        $this->selectedItems[$itemId] = [
            'id' => $item->id,
            'supply_name' => $item->supply->name,
        ];
    }
}
