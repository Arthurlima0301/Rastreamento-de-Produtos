<?php

namespace App\Livewire\Machines;

use App\Models\Machine;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Editar Máquina')]
class MachineEdit extends Component
{
    public int $machineId;

    /**
     * Mount the component with the machine id.
     */
    public function mount(Machine $machine): void
    {
        $this->machineId = $machine->id;
    }

    /**
     * Render the machine edit page.
     */
    public function render(): View
    {
        return view('livewire.machines.machine-edit');
    }
}
