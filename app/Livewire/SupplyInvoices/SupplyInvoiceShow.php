<?php

namespace App\Livewire\SupplyInvoices;

use App\Models\SupplyInvoice;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Detalhes da Nota Fiscal de Insumos')]
class SupplyInvoiceShow extends Component
{
    public int $supplyInvoiceId;

    /**
     * Mount the component with the supply invoice id.
     */
    public function mount(SupplyInvoice $supplyInvoice): void
    {
        $this->supplyInvoiceId = $supplyInvoice->id;
    }

    /**
     * Render the supply invoice detail page.
     */
    public function render()
    {
        $supplyInvoice = SupplyInvoice::with('supplyItems.supply')
            ->withCount('supplyItems')
            ->findOrFail($this->supplyInvoiceId);

        return view('livewire.supply-invoices.supply-invoice-show', compact('supplyInvoice'));
    }
}
