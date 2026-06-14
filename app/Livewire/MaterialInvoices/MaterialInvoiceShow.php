<?php

namespace App\Livewire\MaterialInvoices;

use App\Models\MaterialInvoice;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Detalhes de Nota Fiscal de Material')]
class MaterialInvoiceShow extends Component
{
    public MaterialInvoice $materialInvoice;

    /**
     * Mount the component with the material invoice id.
     */
    public function mount(MaterialInvoice $materialInvoice): void
    {
        $this->materialInvoice = $materialInvoice;
    }

    /**
     * Render the material invoice detail page.
     */
    public function render(): View
    {
        $materialInvoice = $this->materialInvoice
            ->load('itemMaterials.material.order.client')
            ->loadCount('itemMaterials');

        return view('livewire.material-invoices.material-invoice-show', compact('materialInvoice'));
    }
}
