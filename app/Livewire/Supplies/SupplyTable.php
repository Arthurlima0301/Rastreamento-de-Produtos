<?php

namespace App\Livewire\Supplies;

use App\Models\Supply;
use Livewire\Component;
use Livewire\WithPagination;

class SupplyTable extends Component
{
    use WithPagination;

    public string $search = '';

    public function render()
    {
        $supplies = Supply::query()
            ->with('client')
            ->searchByName($this->search)
            ->orderBy('name', 'asc')
            ->paginate(50);

        return view('livewire.supplies.supply-table', compact('supplies'));
    }

    public function destroy(int $supplyId)
    {
        $supply = Supply::findOrFail($supplyId);

        if ($supply->supplyItems()->exists()) {
            return redirect()->route('supplies.index')->with('error', 'Não é possível deletar um insumo que possui itens associados.');
        }

        $supply->delete();

        return redirect()->route('supplies.index')->with('success', 'Insumo deletado com sucesso.');
    }
}
