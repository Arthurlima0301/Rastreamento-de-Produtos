<?php

namespace App\Livewire\Loads;

use Illuminate\Contracts\View\View;
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
    public function render(): View
    {
        return view('livewire.loads.load-index');
    }
}
