<?php

namespace App\Livewire\Invoices;

use App\Models\Invoice;
use Livewire\Component;

class InvoiceTable extends Component
{
    public string $search = '';

    public function render()
    {
        $search = trim($this->search);

        $elementos = Invoice::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where('invoice_code', 'like', $search.'%');
            })
            ->orderBy('issued_at', 'desc')
            ->get();

        return view('livewire.invoices.invoice-table', compact('elementos'));
    }
}
