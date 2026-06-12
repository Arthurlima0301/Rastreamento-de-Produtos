<?php

namespace App\Livewire\ItemMaterials;

use App\Models\ItemMaterial;
use App\Models\Roll;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Detalhes do Item Material')]
class ItemMaterialShow extends Component
{
    public ItemMaterial $itemMaterial;

    public string $search = '';
    public string $filter_status = '';

    /**
     * Mount the component with the given item material.
     */
    public function mount(ItemMaterial $itemMaterial)
    {
        $this->itemMaterial = $itemMaterial;
    }

    /**
     * Render the component view with the rolls related to the item material.
     */
    public function render()
    {
        $rolls = Roll::with('cutLoad.machine')
        ->where('item_material_id', $this->itemMaterial->id)
        ->orderBy('label')
        ->searchByLabel($this->search)
        ->filterByStatus($this->filter_status)
        ->get();

        return view('livewire.item-materials.item-material-show', compact('rolls'));
    }

    /**
     * Delete rolls related to the item material.
     */
    public function deleteRoll(Roll $roll)
    {
        if  ($roll->cutLoad) {
            session()->flash('error', 'Não é possível deletar uma bobina que pertence a uma carga.');
            return;
        }

        $roll->delete();

        session()->flash('success', 'Bobina deletada com sucesso.');
    }


  

}
