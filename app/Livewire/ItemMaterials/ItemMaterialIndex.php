<?php

namespace App\Livewire\ItemMaterials;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Itens de Material')]
class ItemMaterialIndex extends Component
{
    /**
     * Render the item material index page.
     */
    public function render(): View
    {
        return view('livewire.item-materials.item-material-index');
    }
}
