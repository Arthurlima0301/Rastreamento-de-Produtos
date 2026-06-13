<?php

namespace App\Livewire\Orders;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Criar Ordem de Corte')]
class OrderCreate extends Component
{
    /**
     * Render the order creation page.
     */
    public function render()
    {
        return view('livewire.orders.order-create');
    }
}
