<?php

namespace App\Livewire\Clients;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Criar Cliente')]
class ClientCreate extends Component
{
    public function render()
    {
        return view('livewire.clients.client-create');
    }
}
