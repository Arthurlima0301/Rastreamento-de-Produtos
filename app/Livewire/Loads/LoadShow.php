<?php

namespace App\Livewire\Loads;

use App\Models\Load;
use App\Models\Roll;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('Layout.layout')]
#[Title('Detalhes da Carga')]
class LoadShow extends Component
{
    use WithPagination;

    public Load $load;

    public string $search = '';

    public ?int $isEditable = null;

    /**
     * Mount the component with the load id.
     */
    public function mount(Load $load): void
    {
        $this->load = $load;
    }

    /**
     * Render the load detail page.
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
            ->paginate(50);

        return view('livewire.loads.load-show', compact('rolls'));
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
