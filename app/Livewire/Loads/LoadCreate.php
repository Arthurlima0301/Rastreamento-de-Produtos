<?php

namespace App\Livewire\Loads;

use App\Models\Roll;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('Layout.layout')]
#[Title('Criar Carga')]
class LoadCreate extends Component
{
    use WithPagination;

    public string $search = '';

    /**
     * Render the component view with paginated rolls filtered by search term and available status.
     */
    public function render()
    {
        $rolls = Roll::query()
            ->with('itemMaterial.material')
            ->whereNull('load_id')
            ->where('status', 'EM_ESTOQUE')
            ->searchByLabel($this->search)
            ->paginate(50);

        return view('livewire.loads.load-create', compact('rolls'));
    }
}
