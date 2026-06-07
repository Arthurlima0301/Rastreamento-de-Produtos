<?php

namespace App\Livewire\Loads;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Cargas de Corte')]
class LoadIndex extends Component
{
    public function render()
    {
        return view('livewire.loads.load-index');
    }
}
