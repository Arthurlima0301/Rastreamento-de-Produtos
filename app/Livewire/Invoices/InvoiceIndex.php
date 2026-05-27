<?php

namespace App\Livewire\Invoices;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Notas Fiscais')]
class InvoiceIndex extends Component
{
    public function render()
    {
        return view('livewire.invoices.invoice-index');
    }
}
