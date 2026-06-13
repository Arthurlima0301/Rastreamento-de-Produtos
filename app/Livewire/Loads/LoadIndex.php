<?php

namespace App\Livewire\Loads;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Cargas')]
class LoadIndex extends Component
{
    /**
     * Render the load index page.
     */
    public function render()
    {
        return view('livewire.loads.load-index');
    }
}
