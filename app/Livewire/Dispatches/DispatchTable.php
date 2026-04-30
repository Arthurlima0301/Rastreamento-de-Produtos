<?php

namespace App\Livewire\Dispatches;

use App\Models\Dispatch;
use Livewire\Component;

class DispatchTable extends Component
{
    public string $search = '';

    public function render()
    {
        $search = trim($this->search);

        $elementos = Dispatch::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where('invoice', 'like', $search.'%');
            })
            ->orderBy('dispatched_at', 'desc')
            ->get();

        return view('livewire.dispatches.dispatch-table', compact('elementos'));
    }
}
