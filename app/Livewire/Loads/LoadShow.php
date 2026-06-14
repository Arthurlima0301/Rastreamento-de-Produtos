<?php

namespace App\Livewire\Loads;

use App\Models\Load;
use App\Models\Roll;
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
    public function render()
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
}
