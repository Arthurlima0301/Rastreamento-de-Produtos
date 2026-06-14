<?php

namespace App\Livewire\Clients;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Criar Cliente')]
class ClientCreate extends Component
{
    /**
     * Render the client creation page.
     */
    public function render(): View
    {
        return view('livewire.clients.client-create');
    }
}
