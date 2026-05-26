<?php

namespace Tests\Feature;

use App\Livewire\Orders\OrderTable;
use App\Models\Client;
use App\Models\Material;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class OrderMaterialScreenTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_orders()
    {
        $client = Client::factory()->create([
            'name' => 'Cliente Pedido',
        ]);

        Order::factory()->create([
            'code' => 'PED-001',
            'client_id' => $client->id,
        ]);

        $response = $this->get('/orders');

        $response->assertStatus(200);
        $response->assertSee('Ordens de Corte');
        $response->assertSee('PED-001');
        $response->assertSee('Cliente Pedido');
    }

    public function test_show_order_with_materials()
    {
        $client = Client::factory()->create([
            'name' => 'Cliente Detalhe',
        ]);
        $order = Order::factory()->create([
            'code' => 'PED-DETALHE',
            'client_id' => $client->id,
        ]);
        Material::factory()->create([
            'order_id' => $order->id,
            'paper' => 'Papel Couch',
            'shipping_code' => 123456,
            'expedition_code' => 654321,
        ]);

        $response = $this->get("/orders/{$order->id}");

        $response->assertStatus(200);
        $response->assertSee('PED-DETALHE');
        $response->assertSee('Cliente Detalhe');
        $response->assertSee('Papel Couch');
        $response->assertSee('123456');
        $response->assertSee('654321');
    }

    public function test_order_table_searches_by_code()
    {
        Order::factory()->create([
            'code' => 'PED-BUSCA',
        ]);
        Order::factory()->create([
            'code' => 'OUTRO-PEDIDO',
        ]);

        Livewire::test(OrderTable::class)
            ->set('search', 'PED-BUSCA')
            ->assertSee('PED-BUSCA')
            ->assertDontSee('OUTRO-PEDIDO');
    }

}
