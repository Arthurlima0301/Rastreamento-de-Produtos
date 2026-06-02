<?php

namespace App\Livewire\MaterialInvoices;

use App\Models\MaterialInvoice;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Nota Fiscal de Material - Detalhes')]
class MaterialInvoiceShow extends Component
{
    public int $materialInvoiceId;

    public function mount(MaterialInvoice $materialInvoice): void
    {
        $this->materialInvoiceId = $materialInvoice->id;
    }

    public function render()
    {
        $materialInvoice = MaterialInvoice::with('itemMaterials.material.order.client')
            ->withCount('itemMaterials')
            ->findOrFail($this->materialInvoiceId);

        return view('livewire.material-invoices.material-invoice-show', compact('materialInvoice'));
    }
}
