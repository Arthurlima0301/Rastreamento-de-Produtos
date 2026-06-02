<?php

namespace App\Livewire\ItemMaterials;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Itens de Material')]
class ItemMaterialIndex extends Component
{
    public function render()
    {
        return view('livewire.item-materials.item-material-index');
    }
}
