<?php

namespace App\Livewire\Dispatches;

use App\Models\Dispatch;
use Livewire\Component;

class EditDispatch extends Component
{
    public Dispatch $dispatch;

    public bool $isEdited = false;

    public string $invoice;

    public string $dispatched_at;

    /**
     * Enable dispatch editing.
     */
    public function edit()
    {
        $this->isEdited = true;
    }

    /**
     * Cancel editing and restore dispatch data.
     */
    public function cancel()
    {
        $this->invoice = $this->dispatch->invoice ?? 'N/A';
        $this->dispatched_at = $this->dispatch->dispatched_at->format('Y-m-d');
        $this->isEdited = false;
    }

    /**
     * Validate and save dispatch changes.
     */
    public function save()
    {
        $this->validate(
            [
                'invoice' => 'required|string',
                'dispatched_at' => 'required|date',
            ],
            [
                'invoice.required' => 'O número da nota fiscal é obrigatório.',
                'dispatched_at.required' => 'A data de envio é obrigatória.',
                'dispatched_at.date' => 'A data de envio deve ser uma data válida.',
            ]
        );

        $this->dispatch->invoice = $this->invoice;
        $this->dispatch->dispatched_at = $this->dispatched_at;
        $this->dispatch->save();
        $this->isEdited = false;
    }

    /**
     * Load the dispatch data for editing.
     */
    public function mount($dispatchId)
    {
        $this->dispatch = Dispatch::findOrFail($dispatchId);
        $this->invoice = $this->dispatch->invoice ?? 'N/A';
        $this->dispatched_at = $this->dispatch->dispatched_at ? $this->dispatch->dispatched_at->format('Y-m-d') : '';
    }

    /**
     * Render the dispatch edit component.
     */
    public function render()
    {
        return view('livewire.dispatches.edit-dispatch');
    }
}
