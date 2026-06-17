<?php

namespace App\Livewire\Dispatches;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Saídas')]
class DispatchIndex extends Component
{
    /**
     * Render the dispatch index page.
     */
    public function render(): View
    {
        return view('livewire.dispatches.dispatch-index');
    }
}
