<?php

namespace App\Livewire\SupplyInvoices;

use App\Models\SupplyInvoice;
use App\Models\SupplyItem;
use Livewire\Component;
use Livewire\WithPagination;

class SupplyInvoiceTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $parameter = 'desc';


    /**
     * Render the paginated supply invoice table.
     */
    public function render()
    {
        $this->validate([
            'parameter' => 'in:asc,desc',
        ]);

        $supplyInvoices = SupplyInvoice::query()
            ->searchBySupplyInvoiceCode($this->search)
            ->orderBy('issued_at', $this->parameter)
            ->withCount('supplyItems')
            ->paginate(50);

        return view('livewire.supply-invoices.supply-invoice-table', compact('supplyInvoices'));
    }

    /**
     * Delete a supply invoice when it has no dispatches.
     */
    public function delete(SupplyInvoice $supplyInvoice)
    {
        $hasDispatch = $supplyInvoice->supplyItems()
            ->whereHas('dispatchItems')
            ->exists();

        if ($hasDispatch === true) {
            session()->flash('error','Um dos items dessa nota possui saídas vinculadas a ele');
            return;
        }

        $supplyInvoice->delete();
        return redirect()->route('supply-invoices.index')->with('success', 'Nota Fiscal Deletada com Sucesso!');
    }
}
