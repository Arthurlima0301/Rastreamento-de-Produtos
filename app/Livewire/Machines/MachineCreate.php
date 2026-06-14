<?php

namespace App\Livewire\Machines;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Criar Máquina')]
class MachineCreate extends Component
{
    /**
     * Render the machine creation page.
     */
    public function render(): View
    {
        return view('livewire.machines.machine-create');
    }
}
