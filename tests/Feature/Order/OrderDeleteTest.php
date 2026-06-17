<?php

use App\Livewire\Orders\OrderTable;
use App\Models\Material;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class OrderDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_index_page_can_be_rendered()
    {
        $response = $this->get(route('orders.index'));

        $response->assertStatus(200);
        $response->assertSee('orders.order-table');
    }

    public function test_order_can_be_deleted()
    {
        $order = Order::factory()->create([
            'order_code' => 'CUT-700',
        ]);

        Order::factory()->create([
            'order_code' => 'CUT-701',
        ]);

        Livewire::test(OrderTable::class)
            ->call('destroy', $order)
            ->assertRedirect(route('orders.index'));

        $this->assertDatabaseMissing('orders', [
            'id' => $order->id,
        ]);

        $this->assertDatabaseHas('orders', [
            'order_code' => 'CUT-701',
        ]);
    }

    public function test_order_cannot_be_deleted_when_it_has_materials()
    {
        $order = Order::factory()->create([
            'order_code' => 'CUT-800',
        ]);

        Material::factory()->create([
            'order_id' => $order->id,
        ]);

        Livewire::test(OrderTable::class)
            ->call('destroy', $order)
            ->assertRedirect(route('orders.index'));

        $this->assertNotNull(session('error'));

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'order_code' => 'CUT-800',
        ]);
    }
}
