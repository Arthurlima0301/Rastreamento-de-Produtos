<?php

namespace App\Livewire\Supplies;

use App\Models\Supply;
use Livewire\Component;

class SupplyTable extends Component
{
    public string $search = '';

    public function render()
    {
        $supplies = Supply::query()
            ->searchByName($this->search)
            ->get();

        return view('livewire.supplies.supply-table', compact('supplies'));
    }
}
