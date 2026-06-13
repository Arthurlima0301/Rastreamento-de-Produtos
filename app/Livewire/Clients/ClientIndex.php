<?php

namespace App\Livewire\Clients;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Lista de Clientes')]
class ClientIndex extends Component
{
    /**
     * Render the client index page.
     */
    public function render()
    {
        return view('livewire.clients.client-index');
    }
}
