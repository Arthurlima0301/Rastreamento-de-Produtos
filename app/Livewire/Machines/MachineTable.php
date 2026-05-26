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
}
