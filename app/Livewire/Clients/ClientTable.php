<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;

class ClientTable extends Component
{
    use WithPagination;

    public string $search = '';

    public function render()
    {
        $clients = Client::query()
            ->searchByName($this->search)
            ->orderBy('name', 'asc')
            ->paginate(50);

        return view('livewire.clients.client-table', compact('clients'));
    }
}
