<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Editar Cliente')]
class ClientEdit extends Component
{
    public int $clientId;

    /**
     * Mount the component with the client id.
     */
    public function mount(Client $client): void
    {
        $this->clientId = $client->id;
    }

    /**
     * Render the client edit page.
     */
    public function render(): View
    {
        return view('livewire.clients.client-edit');
    }
}
