<?php

namespace App\Livewire\Loads;

use App\Models\Load;
use Livewire\Component;
use Livewire\WithPagination;

class LoadTable extends Component
{
    use WithPagination;

    public string $search = '';

    public function render()
    {
        $loads = Load::query()
            ->with('machine')
            ->withCount('rolls')
            ->withSum('rolls', 'weight')
            ->searchByCode($this->search)
            ->paginate(50);

        return view('livewire.loads.load-table', compact('loads'));
    }

    /**
     * Delete a load and its associated rolls.
     */
    public function deleteLoad(Load $load)
    {
        $load->rolls()->update(
            [
                'load_id' => null,
                'status' => 'EM_ESTOQUE',
                'defect' => null,
                'defect_weight' => null
            ]
        );

        $load->delete();

        return redirect()->route('loads.index')->with('success', 'Carga deletada com sucesso.');
    }
}
