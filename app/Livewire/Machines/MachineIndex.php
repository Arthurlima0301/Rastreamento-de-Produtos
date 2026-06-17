<?php

namespace App\Livewire\Machines;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Máquinas')]
class MachineIndex extends Component
{
    /**
     * Render the machine index page.
     */
    public function render(): View
    {
        return view('livewire.machines.machine-index');
    }
}
