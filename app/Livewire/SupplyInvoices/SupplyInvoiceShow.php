<?php

namespace App\Livewire\SupplyInvoices;

use App\Models\SupplyInvoice;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Detalhes da Nota Fiscal de Insumos')]
class SupplyInvoiceShow extends Component
{
    public SupplyInvoice $supplyInvoice;

    /**
     * Mount the component with the supply invoice id.
     */
    public function mount(SupplyInvoice $supplyInvoice): void
    {
        $this->supplyInvoice = $supplyInvoice;
    }

    /**
     * Render the supply invoice detail page.
     */
    public function render(): View
    {
        $supplyInvoice = $this->supplyInvoice
            ->load('supplyItems.supply')
            ->loadCount('supplyItems');

        return view('livewire.supply-invoices.supply-invoice-show', compact('supplyInvoice'));
    }
}
