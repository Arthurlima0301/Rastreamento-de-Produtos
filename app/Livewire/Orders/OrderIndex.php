<?php

namespace App\Livewire\Orders;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Ordens de Corte')]
class OrderIndex extends Component
{
    /**
     * Render the order index page.
     */
    public function render(): View
    {
        return view('livewire.orders.order-index');
    }
}
