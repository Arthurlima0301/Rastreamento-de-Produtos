<?php

namespace App\Livewire\Loads;

use App\Models\Load;
use App\Models\Pallet;
use Illuminate\View\View;
use Livewire\Component;

class LoadPallets extends Component
{
    public Load $load;
    public string $search = '';

    /**
     * Mount the component with the load id.
     */
    public function mount(Load $load): void
    {
        $this->load = $load;
    }

    /**
     * Render the load pallets page.
     */
    public function render(): View
    {
        $pallets = Pallet::query()
            ->where('load_id', $this->load->id)
            ->with(['cutLoad.machine', 'itemMaterial.material','itemMaterial.materialInvoice'])
            ->searchByLabel($this->search)
            ->paginate(50);

        return view('livewire.loads.load-pallets', compact('pallets'));
    }
}
