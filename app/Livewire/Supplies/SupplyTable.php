<?php

namespace App\Livewire\Supplies;

use App\Models\Supply;
use Livewire\Component;

class SupplyTable extends Component
{
    public string $search = '';

    public function render()
    {
        $search = trim($this->search);

        $elementos = Supply::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where('name', 'like', $search.'%');
            })
            ->get();

        return view('livewire.supplies.supply-table', compact('elementos'));
    }
}
