<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Editar Cliente')]
class ClientEdit extends Component
{
    public int $clientId;

    public function mount(Client $client): void
    {
        $this->clientId = $client->id;
    }

    public function render()
    {
        return view('livewire.clients.client-edit');
    }
}
