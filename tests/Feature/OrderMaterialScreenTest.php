<?php

namespace Tests\Feature;

use App\Livewire\Orders\OrderTable;
use App\Models\Client;
use App\Models\Material;
use App\Models\MaterialInvoice;
use App\Models\MaterialItem;
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

    public function test_list_material_invoices()
    {
        $materialInvoice = MaterialInvoice::factory()->create([
            'material_invoice_code' => '123456',
        ]);

        MaterialItem::factory()->count(2)->create([
            'material_invoice_id' => $materialInvoice->id,
        ]);

        $response = $this->get('/material-invoices');

        $response->assertStatus(200);
        $response->assertSee('Notas Fiscais de Material');
        $response->assertSee('123.456');
        $response->assertSee('2');
    }

    public function test_show_material_invoice_with_items()
    {
        $order = Order::factory()->create([
            'code' => 'PED-MAT',
        ]);
        $material = Material::factory()->create([
            'order_id' => $order->id,
            'paper' => 'Papel Cartao',
        ]);
        $materialInvoice = MaterialInvoice::factory()->create([
            'material_invoice_code' => '654321',
        ]);
        MaterialItem::factory()->create([
            'material_id' => $material->id,
            'material_invoice_id' => $materialInvoice->id,
            'roll_quantity' => 10.50,
            'weight' => 200.25,
        ]);

        $response = $this->get("/material-invoices/{$materialInvoice->id}");

        $response->assertStatus(200);
        $response->assertSee('654.321');
        $response->assertSee('Papel Cartao');
        $response->assertSee('PED-MAT');
        $response->assertSee('10,50');
        $response->assertSee('200,25');
    }

    public function test_list_material_items()
    {
        $order = Order::factory()->create([
            'code' => 'PED-ITEM',
        ]);
        $material = Material::factory()->create([
            'order_id' => $order->id,
            'paper' => 'Papel Duplex',
            'shipping_code' => 111222,
            'expedition_code' => 333444,
        ]);
        $materialInvoice = MaterialInvoice::factory()->create([
            'material_invoice_code' => '987654',
        ]);
        MaterialItem::factory()->create([
            'material_id' => $material->id,
            'material_invoice_id' => $materialInvoice->id,
        ]);

        $response = $this->get('/material-items');

        $response->assertStatus(200);
        $response->assertSee('Itens de Material');
        $response->assertSee('987.654');
        $response->assertSee('PED-ITEM');
        $response->assertSee('Papel Duplex');
        $response->assertSee('111222');
        $response->assertSee('333444');
    }
}
