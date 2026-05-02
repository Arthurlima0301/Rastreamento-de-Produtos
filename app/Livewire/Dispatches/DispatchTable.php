<?php

namespace App\Livewire\Dispatches;

use App\Models\Dispatch;
use Livewire\Component;
use Livewire\WithPagination;

class DispatchTable extends Component
{
    use WithPagination;

    public string $search = '';

    public function render()
    {
        $dispatches = Dispatch::query()
            ->searchByInvoice($this->search)
            ->orderBy('dispatched_at', 'desc')
            ->paginate(50);

        return view('livewire.dispatches.dispatch-table', compact('dispatches'));
    }
}
