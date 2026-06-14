<?php

namespace App\Livewire\MaterialInvoices;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Notas Fiscais de Materiais')]
class MaterialInvoiceIndex extends Component
{
    /**
     * Render the material invoice index page.
     */
    public function render(): View
    {
        return view('livewire.material-invoices.material-invoice-index');
    }
}
