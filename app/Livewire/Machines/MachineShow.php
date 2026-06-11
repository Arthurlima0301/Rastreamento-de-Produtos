<?php

namespace App\Livewire\Machines;

use App\Models\Load;
use App\Models\Machine;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Detalhes da Máquina')]
class MachineShow extends Component
{
    public Machine $machine;
    public string $search = '';

    public function mount(Machine $machine)
    {
        $this->machine = $machine;
    }

    public function render()
    {
        $loads = Load::withSum('rolls','weight')
        ->withCount('rolls')
        ->orderBy('cutted_at', 'desc')
        ->where('machine_id', $this->machine->id)
        ->searchByCode($this->search)
        ->paginate(50);
        return view('livewire.machines.machine-show', compact('loads'));
    }
}
