<?php

namespace App\Livewire\Rolls;

use App\Models\Roll;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class RollTable extends Component
{
    public $search = '';

    /**
     * Render the paginated roll table.
     */
    public function render(): View
    {
        $rolls = Roll::query()
            ->with('itemMaterial.material.order')
            ->with('itemMaterial.materialInvoice')
            ->searchByLabel($this->search)
            ->paginate(50);

        return view('livewire.rolls.roll-table', compact('rolls'));
    }
}
