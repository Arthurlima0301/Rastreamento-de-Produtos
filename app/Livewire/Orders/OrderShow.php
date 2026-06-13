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

    /**
     * Mount the component with the order id.
     */
    public function mount(Order $order): void
    {
        $this->orderId = $order->id;
    }

    /**
     * Render the order detail page.
     */
    public function render()
    {
        $order = Order::with(['client', 'materials'])->findOrFail($this->orderId);

        return view('livewire.orders.order-show', compact('order'));
    }

    /**
     * Cancel material editing.
     */
    public function cancelEdit(): void
    {
        $this->activeEdit = 0;
    }

    /**
     * Select a material for editing.
     */
    public function editMaterial(int $materialId): void
    {
        $this->activeEdit = $materialId;
    }

    /**
     * Remove a material when it has no invoice items.
     */
    public function removeMaterial(Material $material): void
    {
        if (!$material->itemMaterials()->exists()) {
            $material->delete();
            session()->flash('success', 'Material removido com sucesso!');
        } else {
            session()->flash('error', 'Não é possível remover um material que possui itens associados!');
        }

        $this->activeEdit = 0;
    }
}
