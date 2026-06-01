<?php

namespace App\Livewire\Orders;

use App\Models\Material;
use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Detalhes da Ordem de Corte')]
class OrderShow extends Component
{
    public int $orderId;

    public int $activeEdit = 0;

    public function mount(Order $order): void
    {
        $this->orderId = $order->id;
    }

    public function render()
    {
        $order = Order::with(['client', 'materials'])->findOrFail($this->orderId);

        return view('livewire.orders.order-show', compact('order'));
    }

    public function cancelEdit(): void
    {
        $this->activeEdit = 0;
    }

    public function editMaterial(int $materialId): void
    {
        $this->activeEdit = $materialId;
    }

    public function removeMaterial(Material $material): void
    {
        $material->delete();

        $this->activeEdit = 0;
    }
}
