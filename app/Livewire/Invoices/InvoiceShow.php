<?php

namespace App\Livewire\Invoices;

use App\Models\Invoice;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Nota Fiscal - Detalhes')]
class InvoiceShow extends Component
{
    public int $invoiceId;

    public function mount(Invoice $invoice): void
    {
        $this->invoiceId = $invoice->id;
    }

    public function render()
    {
        $invoice = Invoice::with('items', 'items.supply')
            ->withCount('items')
            ->findOrFail($this->invoiceId);

        return view('livewire.invoices.invoice-show', compact('invoice'));
    }
}
