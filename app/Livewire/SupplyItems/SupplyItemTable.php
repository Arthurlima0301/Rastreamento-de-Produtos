<?php

namespace App\Livewire\SupplyItems;

use App\Models\SupplyItem;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class SupplyItemTable extends Component
{
    use WithPagination;

    public string $search = '';

    public bool $available = false;

    /**
     * Render the paginated supply item table.
     */
    public function render(): View
    {
        $supplyItems = SupplyItem::query()
            ->withBalance()
            ->with(['supply.client', 'supplyInvoice'])
            ->filterBalance($this->available)
            ->searchBySupplyName($this->search)
            ->paginate(50);

        return view('livewire.supply-items.supply-item-table', compact('supplyItems'));
    }
}
