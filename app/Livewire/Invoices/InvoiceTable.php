<?php

namespace App\Livewire\Invoices;

use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithPagination;

class InvoiceTable extends Component
{
    use WithPagination;

    public string $search = '';

    public function render()
    {
        $invoices = Invoice::query()
            ->searchByInvoiceCode($this->search)
            ->orderBy('issued_at', 'desc')
            ->withCount('items')
            ->paginate(50);

        return view('livewire.invoices.invoice-table', compact('invoices'));
    }
}
