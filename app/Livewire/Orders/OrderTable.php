<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class OrderTable extends Component
{
    use WithPagination;

    public string $search = '';

    /**
     * Render the paginated order table.
     */
    public function render()
    {
        $orders = Order::query()
            ->with('client')
            ->searchByOrderCode($this->search)
            ->orderBy('order_code', 'asc')
            ->paginate(50);

        return view('livewire.orders.order-table', compact('orders'));
    }

    /**
     * Delete an order when it has no materials.
     */
    public function destroy(int $orderId)
    {
        $order = Order::findOrFail($orderId);

        if ($order->materials()->exists()) {
            return redirect()->route('orders.index')->with('error', 'Não é possível deletar uma ordem de corte que possui materiais associados.');
        }

        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Ordem de corte deletada com sucesso!');
    }
}
