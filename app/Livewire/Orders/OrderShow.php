<?php

namespace App\Livewire\Orders;

use App\Models\Material;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('Layout.layout')]
#[Title('Detalhes da Ordem de Corte')]
class OrderShow extends Component
{
    public Order $order;

    public int $activeEdit = 0;

    /**
     * Mount the component with the order id.
     */
    public function mount(Order $order): void
    {
        $this->order = $order;
    }

    /**
     * Render the order detail page.
     */
    public function render(): View
    {
        $order = $this->order
            ->load(['client', 'materials']);

        return view('livewire.orders.order-show', compact('order'));
    }

    /**
     * Select a material for editing.
     */
    public function editMaterial(int $materialId): void
    {
        $this->activeEdit = $materialId;
    }

    /**
     * Cancel material editing.
     */
    public function cancelEdit(): void
    {
        $this->activeEdit = 0;
    }

    /**
     * Remove a material when it has no invoice items.
     */
    public function removeMaterial(Material $material): void
    {
        if (! $material->itemMaterials()->exists()) {
            $material->delete();
            session()->flash('success', 'Material removido com sucesso!');
            $this->activeEdit = 0;

            return;
        }

        session()->flash('error', 'Não é possível remover um material que possui itens associados!');
    }
}
