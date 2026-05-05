<?php

namespace App\Livewire\Dispatches;

use Livewire\Component;
use App\Models\Dispatch;

class EditDispatchInvoice extends Component
{
    public Dispatch $dispatch;

    public bool $isEdited = false;
    public string $invoice;

    public function edit()
    {
        $this->isEdited = true;
    }

    public function cancel()
    {
        $this->invoice = $this->dispatch->invoice;
        $this->isEdited = false;
    }

    public function save()
    {
        $this->validate(
            [
                'invoice' => 'required|string',
            ],
            [
                'invoice.required' => 'O número da nota fiscal é obrigatório.',
            ]
        );

        $this->dispatch->invoice = $this->invoice;
        $this->dispatch->save();
        $this->isEdited = false;
    }

    public function mount($dispatchId)
    {
        $this->dispatch = Dispatch::find($dispatchId);
        $this->invoice = $this->dispatch->invoice ?? 'N/A';
    }

    public function render()
    {
        return view('livewire.dispatches.edit-dispatch-invoice');
    }
}
