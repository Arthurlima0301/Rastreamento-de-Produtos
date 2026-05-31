<?php

namespace App\Livewire\Orders;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Ordens de Corte')]
class OrderIndex extends Component
{
    public function render()
    {
        return view('livewire.orders.order-index');
    }
}
