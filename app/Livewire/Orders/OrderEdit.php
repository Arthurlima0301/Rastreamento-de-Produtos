<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Editar Ordem de Corte')]
class OrderEdit extends Component
{
    public int $orderId;

    /**
     * Mount the component with the order id.
     */
    public function mount(Order $order): void
    {
        $this->orderId = $order->id;
    }

    /**
     * Render the order edit page.
     */
    public function render()
    {
        return view('livewire.orders.order-edit');
    }
}
