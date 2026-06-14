<?php

namespace App\Livewire\Rolls;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('Layout.layout')]
#[Title('Bobinas')]
class RollIndex extends Component
{
    /**
     * Render the roll index page.
     */
    public function render(): View
    {
        return view('livewire.rolls.roll-index');
    }
}
