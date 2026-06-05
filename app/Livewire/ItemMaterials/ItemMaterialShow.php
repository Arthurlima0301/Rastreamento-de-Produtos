<?php

namespace App\Livewire\ItemMaterials;

use App\Models\ItemMaterial;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Detalhes do Material do Item')]
class ItemMaterialShow extends Component
{
    public ItemMaterial $itemMaterial;

    public function mount(ItemMaterial $itemMaterial)
    {
        $this->itemMaterial = $itemMaterial;
    }

    public function render()
    {
        $rolls = $this->itemMaterial->rolls()->get();

        return view('livewire.item-materials.item-material-show', compact('rolls'));
    }
}
