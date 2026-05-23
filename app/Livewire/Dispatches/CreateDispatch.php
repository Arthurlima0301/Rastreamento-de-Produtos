<?php

namespace App\Livewire\Dispatches;

use App\Models\Item;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('Layout.layout')]
class CreateDispatch extends Component
{
    use WithPagination;

    public string $search = '';

    /**
     * Render the component view with paginated items filtered by search term and balance.
     */
    public function render()
    {

        $items = Item::withBalance()
            ->filterBalance()
            ->searchBySupplyName($this->search)
            ->orderBy('supply_name', 'asc')
            ->orderBy('balance', 'asc')
            ->paginate(50);

        return view('livewire.dispatches.create-dispatch', compact('items'));
    }
}
