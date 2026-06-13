<?php

namespace App\Livewire\SupplyInvoices;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Notas Fiscais de Insumos')]
class SupplyInvoiceIndex extends Component
{
    /**
     * Render the supply invoice index page.
     */
    public function render()
    {
        return view('livewire.supply-invoices.supply-invoice-index');
    }
}
