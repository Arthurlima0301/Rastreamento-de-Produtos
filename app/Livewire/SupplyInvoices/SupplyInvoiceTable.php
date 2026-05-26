<?php

namespace App\Livewire\SupplyInvoices;

use App\Models\SupplyInvoice;
use Livewire\Component;
use Livewire\WithPagination;

class SupplyInvoiceTable extends Component
{
    use WithPagination;

    public string $search = '';

    public string $parameter = 'desc';

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
}
