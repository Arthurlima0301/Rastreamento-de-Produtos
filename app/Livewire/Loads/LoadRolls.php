<?php

namespace App\Livewire\Loads;

use App\Models\Load;
use App\Models\Roll;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class LoadRolls extends Component
{
    use WithPagination;

    public Load $load;

    public string $search = '';

    public ?int $isEditable = null;

    /**
     * Mount the component with the load being displayed.
     */
    public function mount(Load $load): void
    {
        $this->load = $load;
    }

    /**
     * Render rolls associated with this load.
     */
    public function render(): View
    {
        $rolls = Roll::query()
            ->with([
                'itemMaterial.material',
                'itemMaterial.materialInvoice',
            ])
            ->where('load_id', $this->load->id)
            ->searchByLabel($this->search)
            ->orderBy('label')
            ->paginate(50);

        return view('livewire.loads.load-rolls', compact('rolls'));
    }

    /**
     * Edit a specific roll.
     */
    public function editRoll(int $rollId): void
    {
        $this->isEditable = $rollId;
    }

    /**
     * Cancel edit roll.
     */
    public function cancelEditRoll(): void
    {
        $this->isEditable = null;
    }

    /**
     * Remove a specific roll from the load.
     */
    public function removeRoll(int $rollId): void
    {
        $roll = Roll::query()
            ->where('load_id', $this->load->id)
            ->findOrFail($rollId);
            
        $roll->load_id = null;
        $roll->status = 'EM_ESTOQUE';
        $roll->save();

        $this->isEditable = null;

        session()->flash('success', 'Rolo removido da carga com sucesso!');
    }
}
