<?php

namespace App\Livewire\Pallets;

use App\Models\Material;
use App\Models\Pallet;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('Layout.layout')]
class PalletsIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $batchValue = '';

    //
    public function render()
    {
        $pallets = Pallet::query()
            ->with(['itemMaterial.material.order', 'itemMaterial.materialInvoice'])
            ->searchByLabel($this->search)
            ->filterByReturnBatch($this->batchValue)
            ->paginate(50);

        $materials = Material::selectRaw('return_batch')->get();

        return view('livewire.pallets.pallets-index', compact('pallets', 'materials'));
    }

    //
    public function updatingBatchValue()
    {
        $this->resetPage();
    }
}
