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

    public int $loadId;
    public string $search = '';

    public function mount(Load $load): void
    {
        $this->loadId = $load->id;
    }

    public function render()
    {
        $load = Load::query()
            ->with('machine')
            ->withCount('rolls')
            ->findOrFail($this->loadId);

        $rolls = Roll::query()
            ->with([
                'itemMaterial.material',
                'itemMaterial.materialInvoice',
            ])
            ->where('load_id', $this->loadId)
            ->searchByLabel($this->search)
            ->paginate(50);

        return view('livewire.loads.load-show', compact('load', 'rolls'));
    }
}
