<?php

namespace App\Livewire\Loads;

use App\Models\Load;
use Livewire\Component;
use Livewire\WithPagination;

class LoadTable extends Component
{
    use WithPagination;

    public function render()
    {
        $loads = Load::query()
            ->with('machine')
            ->withCount('rolls')
            ->withSum('rolls', 'weight')
            ->paginate(50);

        return view('livewire.loads.load-table', compact('loads'));
    }

    /**
     * Delete a load and its associated rolls.
     */
    public function deleteLoad(Load $load)
    {
        $load->rolls()->update(['load_id' => null]); // Desassocia as bobinas da carga
        $load->delete();

        return redirect()->route('loads.index')->with('success', 'Carga deletada com sucesso.');
    }
}
