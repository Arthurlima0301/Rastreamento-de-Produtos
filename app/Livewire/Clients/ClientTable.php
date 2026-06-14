<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;

class ClientTable extends Component
{
    use WithPagination;

    public string $search = '';

    /**
     * Render the paginated client table.
     */
    public function render()
    {
        $clients = Client::query()
            ->searchByName($this->search)
            ->orderBy('name', 'asc')
            ->paginate(50);

        return view('livewire.clients.client-table', compact('clients'));
    }

    /**
     * Delete a client when it has no related records.
     */
    public function destroy(Client $client)
    {
        if (! $client->supplies()->exists() && ! $client->orders()->exists()) {
            $client->delete();

            return redirect()->route('clients.index')->with('success', 'Cliente deletado com sucesso!');
        }

        return redirect()->route('clients.index')
            ->with('error', 'Não é possível deletar um cliente que possui insumos ou ordens associadas.');
    }
}
