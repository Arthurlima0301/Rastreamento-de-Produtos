<?php

namespace App\Livewire\Dispatches;

use App\Models\SupplyItem;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('Layout.layout')]
class DispatchCreate extends Component
{
    use WithPagination;

    public string $search = '';

    /**
     * Render the component view with paginated supply items filtered by search term and balance.
     */
    public function render()
    {

        $supplyItems = SupplyItem::withBalance()
            ->filterBalance()
            ->searchBySupplyName($this->search)
            ->orderBy('supply_name', 'asc')
            ->orderBy('balance', 'asc')
            ->paginate(50);

        return view('livewire.dispatches.dispatch-create', compact('supplyItems'));
    }
}
