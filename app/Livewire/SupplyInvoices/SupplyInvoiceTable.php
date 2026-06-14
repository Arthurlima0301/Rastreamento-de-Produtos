<?php

namespace App\Livewire\SupplyInvoices;

use App\Models\SupplyInvoice;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class SupplyInvoiceTable extends Component
{
    use WithPagination;

    public string $search = '';

    public string $sortDirection = 'desc';

    /**
     * Render the paginated supply invoice table.
     */
    public function render(): View
    {
        $this->validate([
            'sortDirection' => 'in:asc,desc',
        ]);

        $supplyInvoices = SupplyInvoice::query()
            ->searchBySupplyInvoiceCode($this->search)
            ->orderBy('issued_at', $this->sortDirection)
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

        if (! $hasDispatch) {
            $supplyInvoice->delete();

            return redirect()->route('supply-invoices.index')->with('success', 'Nota Fiscal Deletada com Sucesso!');
        }

        session()->flash('error', 'Um dos items dessa nota possui saídas vinculadas a ele');
    }
}
