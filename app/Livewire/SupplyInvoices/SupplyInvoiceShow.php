<?php

namespace App\Livewire\SupplyInvoices;

use App\Models\SupplyInvoice;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Nota Fiscal - Detalhes')]
class SupplyInvoiceShow extends Component
{
    public int $supplyInvoiceId;

    public function mount(SupplyInvoice $supplyInvoice): void
    {
        $this->supplyInvoiceId = $supplyInvoice->id;
    }

    public function render()
    {
        $supplyInvoice = SupplyInvoice::with('supplyItems.supply')
            ->withCount('supplyItems')
            ->findOrFail($this->supplyInvoiceId);

        return view('livewire.supply-invoices.supply-invoice-show', compact('supplyInvoice'));
    }
}
