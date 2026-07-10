<?php

namespace App\Livewire\Loads;

use App\Models\Material;
use App\Models\Roll;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('Layout.layout')]
#[Title('Criar Carga')]
class LoadCreate extends Component
{
    use WithPagination;

    public ?int $materialId = null;
    public string $search = '';

    /**
     * Render the component view with paginated rolls filtered by search term and available status.
     */
    public function render(): View
    {
        $materials = Material::query()
            ->select('materials.*')
            ->join('orders', 'orders.id', '=', 'materials.order_id')
            ->orderBy('paper')
            ->where('orders.status', '=', 'ATIVA')
            ->get();

        $rolls = Roll::query()
            ->with('itemMaterial.material','itemMaterial.materialInvoice')
            ->whereNull('load_id')
            ->where('status', 'EM_ESTOQUE')
            ->when(
                $this->materialId,
                fn($query) => $query->whereHas('itemMaterial', fn($q) => $q->where('material_id', $this->materialId)),
                fn($query) => $query->whereRaw('1 = 0')
            )
            ->searchByLabel($this->search)
            ->paginate(50);

        return view('livewire.loads.load-create', compact('rolls', 'materials'));
    }

    /**
     * Reset the selected rolls when the materialId is updated.
     */
    public function updatedMaterialId()
    {
        $this->dispatch('clear-selection');
    }
}
