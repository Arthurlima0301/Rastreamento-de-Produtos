<?php

namespace App\Livewire\Orders;

use App\Models\Client;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class OrderForm extends Component
{
    public ?int $orderId = null;

    public string $order_code = '';

    public ?int $client_id = null;

    public string $status = '';

    /**
     * Load the order data when editing.
     */
    public function mount(?int $orderId = null): void
    {
        $this->orderId = $orderId;

        if ($this->orderId) {
            $order = Order::findOrFail($this->orderId);
            $this->order_code = $order->order_code;
            $this->client_id = $order->client_id;
        }
    }

    /**
     * Validate and save the order.
     */
    public function save()
    {
        $validated = $this->validate([
            'order_code' => 'required|string|max:150|unique:orders,order_code,'.$this->orderId,
            'client_id' => 'required|exists:clients,id',
            'status' => 'required|in:FINALIZADA,ATIVA',
        ], [
            'order_code.required' => 'O campo "Código" da ordem e obrigatorio.',
            'order_code.max' => 'O campo "Código" da ordem deve ter no maximo 150 caracteres.',
            'order_code.unique' => 'O codigo da ordem já está em uso.',
            'client_id.required' => 'O campo "Cliente" é obrigatório.',
            'client_id.exists' => 'O cliente informado é inválido.',
            'status.required' => 'O status do pedido deve ser informado.',
        ]);

        if ($this->orderId) {
            Order::findOrFail($this->orderId)->update($validated);

            return redirect()->route('orders.index')->with('success', 'Ordem de corte atualizada com sucesso!');
        }

        Order::create($validated);

        return redirect()->route('orders.index')->with('success', 'Ordem de corte criada com sucesso!');
    }

    /**
     * Render the order form.
     */
    public function render(): View
    {
        $clients = Client::orderBy('name', 'asc')->get();

        return view('livewire.orders.order-form', compact('clients'));
    }
}
