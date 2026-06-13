<?php

namespace App\Livewire\Rolls;

use App\Models\Roll;
use Livewire\Component;

class RollTable extends Component
{
    public $search = '';
    
    /**
     * Render the paginated roll table.
     */
    public function render()
    {
        $rolls = Roll::query()
            ->with('itemMaterial')
            ->searchByLabel($this->search)
            ->paginate(50);

        return view('livewire.rolls.roll-table', compact('rolls'));
    }
}
