<?php

namespace App\Livewire\Machines;

use App\Models\Machine;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Editar Máquina')]
class MachineEdit extends Component
{
    public int $machineId;

    public function mount(Machine $machine): void
    {
        $this->machineId = $machine->id;
    }

    public function render()
    {
        return view('livewire.machines.machine-edit');
    }
}
