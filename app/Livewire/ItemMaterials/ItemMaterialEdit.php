<?php

namespace App\Livewire\ItemMaterials;

use App\Models\ItemMaterial;
use App\Models\Material;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Editar Item Material')]
class ItemMaterialEdit extends Component
{
    public ItemMaterial $itemMaterial;

    public string $search = '';

    /**
     * Mount the component with the item material.
     */
    public function mount(ItemMaterial $itemMaterial)
    {
        $this->itemMaterial = $itemMaterial;
    }

    /**
     * Render the material replacement page.
     */
    public function render(): View
    {
        $materials = Material::with('order')
            ->searchByPaper($this->search)
            ->paginate(50);

        return view('livewire.item-materials.item-material-edit', compact('materials'));
    }

    /**
     * Replace the material linked to the invoice item.
     */
    public function replaceMaterial(int $materialId): void
    {
        $this->itemMaterial->material_id = $materialId;
        $this->itemMaterial->save();

        session()->flash('success', 'Material substituído com sucesso!');
        $this->redirect(route('material-invoices.show', $this->itemMaterial->materialInvoice->id));
    }
}
