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

    /**
     * Render the paginated material invoice table.
     */
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

    /**
     * Delete the invoice from Material
     */
    public function delete(MaterialInvoice $materialInvoice)
    {
        $hasRolls = $materialInvoice
            ->itemMaterials()
            ->whereHas('rolls.cutLoad')
            ->exists();

        if (! $hasRolls) {
            $materialInvoice->delete();

            return redirect()->route('material-invoices.index')->with('success', 'Nota fiscal deletada com sucesso!');
        }

        return redirect()->route('material-invoices.index')
            ->with('error', 'Não é possível deletar essa nota fiscal, pois uma das bobinas pertencentes à ela está associada a uma carga.');
    }
}
