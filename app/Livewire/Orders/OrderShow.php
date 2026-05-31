<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Detalhes da Ordem de Corte')]
class OrderShow extends Component
{
    public int $orderId;

    public function mount(Order $order): void
    {
        $this->orderId = $order->id;
    }

    public function render()
    {
        $order = Order::with('client')->findOrFail($this->orderId);

        return view('livewire.orders.order-show', compact('order'));
    }
}
