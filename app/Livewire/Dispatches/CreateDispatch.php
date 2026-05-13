<?php

namespace App\Livewire\Dispatches;

use App\Models\Item;
use Livewire\Component;
use Livewire\WithPagination;

class CreateDispatch extends Component
{
    use WithPagination;

    public string $search = '';

    public array $selectedItems = [];

    public function render()
    {
        $items = Item::withBalance()
            ->filterBalance()
            ->searchBySupplyName($this->search)
            ->paginate(50);

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
