<?php

namespace App\Livewire\Dispatches;

use App\Models\Dispatch;
use Livewire\Component;

class DispatchTable extends Component
{
    public string $search = '';

    public function render()
    {
        $dispatches = Dispatch::query()
            ->searchByInvoice($this->search)
            ->orderBy('dispatched_at', 'desc')
            ->get();

        return view('livewire.dispatches.dispatch-table', compact('dispatches'));
    }
}
