<?php

namespace App\Livewire\Machines;

use App\Models\Machine;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class MachineTable extends Component
{
    use WithPagination;

    public string $search = '';

    /**
     * Render the paginated machine table.
     */
    public function render(): View
    {
        $machines = Machine::query()
            ->searchByName($this->search)
            ->orderBy('name', 'asc')
            ->paginate(50);

        return view('livewire.machines.machine-table', compact('machines'));
    }

    /**
     * Delete a machine when it has no loads.
     */
    public function destroy(Machine $machine)
    {
        if (! $machine->loads()->exists()) {
            $machine->delete();

            return redirect()->route('machines.index')->with('success', 'Máquina deletada com sucesso!');
        }

        return redirect()
            ->route('machines.index')
            ->with('error', 'Não é possível deletar esta máquina, pois ela está associada a um ou mais cargas.');
    }
}
