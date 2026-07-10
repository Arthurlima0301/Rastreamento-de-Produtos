<?php

namespace App\Livewire\Loads;

use App\Models\Load;
use App\Models\Roll;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Adicionar Bobinas à Carga')]
class LoadAddRolls extends Component
{
    public Load $load;
    public string $search = '';

    /**
     * Mount the component with the load being updated.
     */
    public function mount(Load $load)
    {
        $this->load = $load->load('rolls');
    }

    /**
     * Render available rolls and rolls already associated with this load.
     */
    public function render()
    {
        $rolls = Roll::query()
            ->with('itemMaterial.material')
            ->whereHas('itemMaterial', function ($query) {
                $query->where('material_id', $this->load->rolls->first()->itemMaterial->material_id);
            })
            ->whereNull('load_id')
            ->Orwhere('load_id', $this->load->id)
            ->searchByLabel($this->search)
            ->orderBy('load_id','desc')
            ->paginate(50);

        return view('livewire.loads.load-add-rolls', compact('rolls'));
    }


    /**
     * Add a roll to the load when the roll limit allows it.
     */
    public function addRoll(int $rollId)
    {
        if ($this->load->rolls()->count() >= 6) {
            session()->flash('error', "Limite de 6 bobinas por carga atingido!");
            return;
        }

        $roll = Roll::findOrFail($rollId);
        $roll->status = 'CORTADA';
        $roll->load_id = $this->load->id;
        $roll->save();

        session()->flash('success', "Bobina adicionada à carga com sucesso!");
    }
}
