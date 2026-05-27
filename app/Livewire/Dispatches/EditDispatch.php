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

    public function edit()
    {
        $this->isEdited = true;
    }

    public function cancel()
    {
        $this->invoice = $this->dispatch->invoice ?? 'N/A';
        $this->dispatched_at = $this->dispatch->dispatched_at->format('Y-m-d');
        $this->isEdited = false;
    }

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

    public function mount($dispatchId)
    {
        $this->dispatch = Dispatch::findOrFail($dispatchId);
        $this->invoice = $this->dispatch->invoice ?? 'N/A';
        $this->dispatched_at = $this->dispatch->dispatched_at ? $this->dispatch->dispatched_at->format('Y-m-d') : '';
    }

    public function render()
    {
        return view('livewire.dispatches.edit-dispatch');
    }
}
