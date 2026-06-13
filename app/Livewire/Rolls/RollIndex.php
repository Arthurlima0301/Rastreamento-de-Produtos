<?php

namespace App\Livewire\Rolls;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('Layout.layout')]
#[Title('Bobinas')]
class RollIndex extends Component
{
    /**
     * Render the roll index page.
     */
    public function render()
    {
        return view('livewire.rolls.roll-index');
    }
}
