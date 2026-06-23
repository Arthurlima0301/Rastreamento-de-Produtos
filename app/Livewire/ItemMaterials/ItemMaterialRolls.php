<?php

namespace App\Livewire\ItemMaterials;

use App\Models\Roll;
use Livewire\Component;

class ItemMaterialRolls extends Component
{
    public ?int $itemMaterialId;
    public string $search = '';
    public string $statusFilter = '';

    public function mount(?int $itemMaterialId)
    {
        $this->itemMaterialId = $itemMaterialId;
    }

    public function render()
    {
        $rolls = Roll::with('cutLoad.machine')
            ->where('item_material_id', $this->itemMaterialId)
            ->orderBy('label')
            ->searchByLabel($this->search)
            ->filterByStatus($this->statusFilter)
            ->get();


        return view('item-materials.item-material-rolls', compact('rolls'));
    }

    /**
     * Delete rolls related to the item material.
     */
    public function deleteRoll(Roll $roll)
    {
        if (! $roll->cutLoad) {
            $roll->delete();

            return redirect()->back()->with('success', 'Bobina deletada com sucesso!');
        }

        return redirect()->back()->with('error', 'Não é possível deletar uma bobina que está associada a um corte.');
    }
}
