<?php

namespace App\Livewire\Dispatches;

use App\Models\SupplyItem;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('Layout.layout')]
class DispatchCreate extends Component
{
    use WithPagination;

    public string $search = '';
    public bool $orderByFrequency = false;

    /**
     * Render the component view with paginated supply items filtered by search term and balance.
     */
    public function render(): View
    {

        $supplyItems = SupplyItem::query()
            ->with(['supply.client', 'supplyInvoice'])
            ->withBalance()
            ->filterBalance()
            ->searchBySupplyName($this->search)
            ->when($this->orderByFrequency, fn ($query) => $query->withFrequency())
            ->orderBy('supplies.name','asc')
            ->paginate(50);

        return view('livewire.dispatches.dispatch-create', compact('supplyItems'));
    }

    /**
     *  Toggle ordering by most used supply items.
     */
    public function orderByMostUssed() : void
    {
        $this->orderByFrequency = !$this->orderByFrequency;
    }
}
