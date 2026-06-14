<?php

namespace App\Livewire\Orders;

use Illuminate\Contracts\View\View;
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
    public function render(): View
    {
        return view('livewire.orders.order-create');
    }
}
