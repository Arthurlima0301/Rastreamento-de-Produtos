<?php

namespace App\Livewire\Machines;

use App\Models\Machine;
use Livewire\Component;
use Livewire\WithPagination;

class MachineTable extends Component
{
    use WithPagination;

    public string $search = '';

    public function render()
    {
        $machines = Machine::query()
            ->searchByName($this->search)
            ->orderBy('name', 'asc')
            ->paginate(50);

        return view('livewire.machines.machine-table', compact('machines'));
    }

    public function destroy(Machine $machine)
    {
        if ($machine->loads()->exists()) {
            return redirect()
                ->route('machines.index')
                ->with('error', 'Não é possível deletar esta máquina, pois ela está associada a um ou mais cargas.');
        }

        $machine->delete();
        return redirect()->route('machines.index')->with('success', 'Máquina deletada com sucesso!');
    }
}
