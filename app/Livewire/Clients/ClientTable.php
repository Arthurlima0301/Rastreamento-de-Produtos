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

    public function destroy(int $clientId)
    {
        $client = Client::findOrFail($clientId);

        if ($client->supplies()->exists() || $client->orders()->exists()) {
            return redirect()->route('clients.index')->with('error', 'Não é possível deletar um cliente que possui insumos ou ordens associadas.');
        }

        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Cliente deletado com sucesso!');
    }
}
