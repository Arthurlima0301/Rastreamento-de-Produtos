<?php

namespace App\Livewire\ItemMaterials;

use App\Models\ItemMaterial;
use App\Rules\Pallets\GeneratePalletValidationRule;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Services\Pallets\GeneratePallets;
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

    /**
     * Toggle the active tab in the component.
     */
    public function toggleTab($tab)
    {
        $this->page = $tab;
    }


    /**
     * Generate pallets for the item material.
     */
    public function generatePallets(GeneratePallets $generatePallets)
    {
        $this->validate([
            'itemMaterial.id' => ['required', new GeneratePalletValidationRule()],
        ]);

        try {
            $generatePallets->execute($this->itemMaterial);

            session()->flash('success', 'Pallets gerados com sucesso.');
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao gerar pallets.' . $e->getMessage());
        }
    }
}
