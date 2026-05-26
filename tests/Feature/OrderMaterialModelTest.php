<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Material;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class OrderMaterialModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_orders_and_materials_tables_have_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('orders', [
            'id',
            'code',
            'client_id',
            'created_at',
            'updated_at',
        ]));

        $this->assertTrue(Schema::hasColumns('materials', [
            'id',
            'order_id',
            'item_number',
            'shipping_code',
            'roll',
            'width',
            'length',
            'sheets',
            'grammage',
            'expedition_code',
            'paper',
            'return_lot',
            'packages',
            'net_weight_p',
            'gross_weight_p',
            'created_at',
            'updated_at',
        ]));
    }

    public function test_order_and_material_factories_create_relationships()
    {
        $client = Client::factory()->create();
        $order = Order::factory()->create([
            'client_id' => $client->id,
        ]);
        $material = Material::factory()->create([
            'order_id' => $order->id,
        ]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'client_id' => $client->id,
        ]);
        $this->assertDatabaseHas('materials', [
            'id' => $material->id,
            'order_id' => $order->id,
        ]);

        $this->assertTrue($order->client->is($client));
        $this->assertTrue($client->orders()->whereKey($order->id)->exists());
        $this->assertTrue($order->materials()->whereKey($material->id)->exists());
        $this->assertTrue($material->order->is($order));
    }
}
