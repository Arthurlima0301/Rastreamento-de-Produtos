<?php

namespace App\Livewire\SupplyInvoices;

use Illuminate\Contracts\View\View;
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
    public function render(): View
    {
        return view('livewire.supply-invoices.supply-invoice-index');
    }
}
