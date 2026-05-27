<?php

namespace App\Livewire\Dispatches;

use App\Models\Dispatch;
use Livewire\Component;
use Livewire\WithPagination;

class DispatchTable extends Component
{
    use WithPagination;

    public string $search = '';

    public string $parameter = 'desc';

    public function render()
    {
        $this->validate([
            'parameter' => 'in:asc,desc',
        ]);

        $dispatches = Dispatch::query()
            ->searchByInvoice($this->search)
            ->orderBy('dispatched_at', $this->parameter)
            ->paginate(50);

        return view('livewire.dispatches.dispatch-table', compact('dispatches'));
    }

    public function destroy(Dispatch $dispatch)
    {
        $dispatch->delete();

        return redirect()->route('dispatches.index')->with('success', 'Saída excluída com sucesso!');
    }
}
