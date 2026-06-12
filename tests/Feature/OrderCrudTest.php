<?php

namespace Tests\Feature;

use App\Livewire\Orders\OrderForm;
use App\Livewire\Orders\OrderTable;
use App\Models\Client;
use App\Models\Material;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class OrderCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_order_with_valid_data(): void
    {
        $client = Client::factory()->create();

        Livewire::test(OrderForm::class)
            ->set('order_code', 'CUT-100')
            ->set('client_id', $client->id)
            ->set('status', 'ATIVA')
            ->call('save')
            ->assertRedirect(route('orders.index'));

        $this->assertDatabaseHas('orders', [
            'order_code' => 'CUT-100',
            'client_id' => $client->id,
            'status' => 'ATIVA',
        ]);
    }

    public function test_do_not_create_order_with_invalid_data(): void
    {
        Livewire::test(OrderForm::class)
            ->set('order_code', '')
            ->set('client_id', null)
            ->call('save')
            ->assertHasErrors(['order_code', 'client_id']);
    }

    public function test_list_orders(): void
    {
        Order::factory()->create([
            'order_code' => 'CUT-200',
        ]);

        $response = $this->get('/orders');

        $response->assertStatus(200);
        $response->assertSee('CUT-200');
    }

    public function test_show_order_with_materials(): void
    {
        $order = Order::factory()->create([
            'order_code' => 'CUT-300',
        ]);

        Material::factory()->create([
            'order_id' => $order->id,
            'item_number' => 10,
            'shipment_code' => 12345,
            'grammage' => 250.5,
            'package_net_weight' => 1200.75,
            'package_gross_weight' => 1300.8,
            'paper' => 'Kraft',
        ]);

        $response = $this->get(route('orders.show', $order));

        $response->assertStatus(200);
        $response->assertSee('CUT-300');
        $response->assertSee('Kraft');
        $response->assertSee('250,50');
        $response->assertSee('1.200,75');
        $response->assertSee('1.300,80');
    }

    public function test_update_order(): void
    {
        $client = Client::factory()->create();
        $order = Order::factory()->create([
            'order_code' => 'CUT-400',
        ]);

        Livewire::test(OrderForm::class, ['orderId' => $order->id])
            ->set('order_code', 'CUT-401')
            ->set('client_id', $client->id)
            ->set('status', 'ATIVA')
            ->call('save')
            ->assertRedirect(route('orders.index'));

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'order_code' => 'CUT-401',
            'client_id' => $client->id,
            'status' => 'ATIVA',
        ]);
    }

    public function test_order_belongs_to_client(): void
    {
        $client = Client::factory()->create();

        $order = Order::factory()->create([
            'client_id' => $client->id,
        ]);

        $this->assertTrue($order->client->is($client));
    }

    public function test_delete_order(): void
    {
        $order = Order::factory()->create([
            'order_code' => 'CUT-500',
        ]);

        Livewire::test(OrderTable::class)
            ->call('destroy', $order->id)
            ->assertRedirect(route('orders.index'));

        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
    }

    public function test_do_not_delete_order_with_materials(): void
    {
        $order = Order::factory()->create([
            'order_code' => 'CUT-600',
        ]);

        Material::factory()->create([
            'order_id' => $order->id,
        ]);

        Livewire::test(OrderTable::class)
            ->call('destroy', $order->id)
            ->assertRedirect(route('orders.index'));

        $this->assertDatabaseHas('orders', ['id' => $order->id]);
    }
}
