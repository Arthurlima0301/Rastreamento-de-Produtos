<?php

namespace App\Livewire\Dispatches;

use App\Models\Dispatch;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class DispatchTable extends Component
{
    use WithPagination;

    public string $search = '';

    public string $sortDirection = 'desc';

    /**
     * Render the paginated dispatch table.
     */
    public function render(): View
    {
        $this->validate([
            'sortDirection' => 'in:asc,desc',
        ], [
            'sortDirection.in' => 'O parâmetro de ordenação deve ser "asc" ou "desc".',
        ]);

        $dispatches = Dispatch::query()
            ->searchByInvoice($this->search)
            ->orderBy('dispatched_at', $this->sortDirection)
            ->paginate(50);

        return view('livewire.dispatches.dispatch-table', compact('dispatches'));
    }

    /**
     * Delete a dispatch record.
     */
    public function destroy(Dispatch $dispatch)
    {
        $dispatch->delete();

        return redirect()->route('dispatches.index')->with('success', 'Saída excluída com sucesso!');
    }
}
