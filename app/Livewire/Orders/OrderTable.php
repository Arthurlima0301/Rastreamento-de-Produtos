<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class OrderTable extends Component
{
    use WithPagination;

    public string $search = '';

    public function render()
    {
        $orders = Order::query()
            ->with('client')
            ->withCount('materials')
            ->searchByCode($this->search)
            ->orderBy('code', 'asc')
            ->paginate(50);

        return view('livewire.orders.order-table', compact('orders'));
    }
}
