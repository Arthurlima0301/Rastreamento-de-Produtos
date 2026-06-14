<?php

namespace App\Livewire\Supplies;

use App\Models\Supply;
use Livewire\Component;
use Livewire\WithPagination;

class SupplyTable extends Component
{
    use WithPagination;

    public string $search = '';

    /**
     * Render the paginated supply table.
     */
    public function render()
    {
        $supplies = Supply::query()
            ->with('client')
            ->searchByName($this->search)
            ->orderBy('name', 'asc')
            ->paginate(50);

        return view('livewire.supplies.supply-table', compact('supplies'));
    }

    /**
     * Delete a supply when it has no items.
     */
    public function destroy(Supply $supply)
    {
        if (! $supply->supplyItems()->exists()) {
            $supply->delete();

            return redirect()->route('supplies.index')->with('success', 'Insumo deletado com sucesso!');
        }

        return redirect()->route('supplies.index')
            ->with('error', 'Não é possível deletar um insumo que possui itens associados.');
    }
}
