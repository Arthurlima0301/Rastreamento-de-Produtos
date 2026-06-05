<?php

namespace App\Livewire\Machines;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Máquinas')]
class MachineIndex extends Component
{
    public function render()
    {
        return view('livewire.machines.machine-index');
    }
}
