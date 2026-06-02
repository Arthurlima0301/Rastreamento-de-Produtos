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
            ->searchByInvoiceCode($this->search)
            ->orderBy('issued_at', $this->parameter)
            ->withCount('itemMaterials')
            ->paginate(50);

        return view('livewire.material-invoices.material-invoice-table', compact('materialInvoices'));
    }
}
