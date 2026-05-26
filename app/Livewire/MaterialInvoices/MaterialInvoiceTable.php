<?php

namespace App\Livewire\MaterialInvoices;

use App\Models\MaterialInvoice;
use Livewire\Component;
use Livewire\WithPagination;

class MaterialInvoiceTable extends Component
{
    use WithPagination;

    public string $search = '';

    public string $parameter = 'desc';

    public function render()
    {
        $this->validate([
            'parameter' => 'in:asc,desc',
        ]);

        $materialInvoices = MaterialInvoice::query()
            ->searchByMaterialInvoiceCode($this->search)
            ->orderBy('created_at', $this->parameter)
            ->withCount('materialItems')
            ->paginate(50);

        return view('livewire.material-invoices.material-invoice-table', compact('materialInvoices'));
    }
}
