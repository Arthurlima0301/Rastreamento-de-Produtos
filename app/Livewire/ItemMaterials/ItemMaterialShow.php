<?php

namespace App\Livewire\ItemMaterials;

use App\Models\ItemMaterial;
use App\Models\Roll;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Detalhes do Item Material')]
class ItemMaterialShow extends Component
{
    public ItemMaterial $itemMaterial;
    public string $page = 'rolls';

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
    public function render(): View
    {
    
        $totalWeight = $this->itemMaterial->rolls()->sum('weight');

        return view('livewire.item-materials.item-material-show', compact('totalWeight'));
    }


    public function toggleTab($tab)
    {
        $this->page = $tab;
    }
}
