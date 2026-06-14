<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ClientForm extends Component
{
    public ?int $clientId = null;

    public string $name = '';

    /**
     * Load the client data when editing.
     */
    public function mount(?int $clientId = null): void
    {
        $this->clientId = $clientId;

        if ($this->clientId) {
            $client = Client::findOrFail($this->clientId);
            $this->name = $client->name;
        }
    }

    /**
     * Validate and save the client.
     */
    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string',
        ], [
            'name.required' => 'O campo "Nome" é obrigatório.',
        ]);

        if ($this->clientId) {
            Client::findOrFail($this->clientId)->update($validated);

            return redirect()->route('clients.index')->with('success', 'Cliente atualizado com sucesso!');
        }

        Client::create($validated);

        return redirect()->route('clients.index')->with('success', 'Cliente criado com sucesso!');
    }

    /**
     * Render the client form.
     */
    public function render(): View
    {
        return view('livewire.clients.client-form');
    }
}
