<?php

namespace App\Livewire\Invoices;

use App\Models\Invoice;
use Livewire\Component;

class InvoiceTable extends Component
{
    public string $search = '';

    public function render()
    {
        $invoices = Invoice::query()
            ->searchByInvoiceCode($this->search)
            ->orderBy('issued_at', 'desc')
            ->get();

        return view('livewire.invoices.invoice-table', compact('invoices'));
    }
}
