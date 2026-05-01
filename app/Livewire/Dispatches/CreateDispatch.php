<?php

namespace App\Livewire\Dispatches;

use Livewire\Component;
use App\Models\Item;

class CreateDispatch extends Component
{
    public string $search = '';
    public array $selectedItems = [];

    public function render()
    {
        $search = trim($this->search);

        $elementos = Item::with('invoice', 'supply')
            ->withSum('dispatchItems', 'quantity')
            ->when($search !== '', function ($query) use ($search) {
                $query->whereHas('supply', function ($query) use ($search) {
                    $query->where('name', 'like', $search . '%');
                });
            })
            ->get();

        return view('livewire.dispatches.create-dispatch', compact('elementos'));
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
