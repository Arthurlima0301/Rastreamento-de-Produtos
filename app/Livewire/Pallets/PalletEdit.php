<?php

namespace App\Livewire\Pallets;

use App\Models\Load;
use App\Models\Pallet;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Rules\Pallets\ReplaceLabelValidate;

#[Layout('layout.layout')]
#[Title('Editar Pallet')]
class PalletEdit extends Component
{
    public Pallet $pallet;
    public float $palletLabel;
    public float $cutLoadId;

    /**
     * Mount the component with the given pallet.
     */
    public function mount(Pallet $pallet)
    {
        $this->pallet = $pallet->load('cutLoad.machine','itemMaterial.material'); 
        $this->palletLabel = $this->pallet->label;
        $this->cutLoadId = $this->pallet->cutLoad->id;
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        $loads = Load::query()
            ->withSufficientBalance($this->pallet->item_material_id, $this->pallet->package_net_weight)
            ->where('id', '!=', $this->pallet->load_id)
            ->get();
        
        return view('livewire.pallets.pallet-edit',compact('loads'));
    }

    /**
     * Update the pallet with the new values.
     */
    public function save()
    {
        $this->validate([
            'palletLabel' => ['required', 'numeric', 'min:0', 'max:9999',new ReplaceLabelValidate($this->pallet->id)],
            'cutLoadId' => ['required', 'exists:loads,id'],
        ]);

        $this->pallet->update([
            'label' => $this->palletLabel,
            'load_id' => $this->cutLoadId,
        ]);

        session()->flash('success', 'Pallet atualizado com sucesso!');
    }
}
