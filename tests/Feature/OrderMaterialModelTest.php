<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Material;
use App\Models\MaterialInvoice;
use App\Models\MaterialItem;
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

        $this->assertTrue(Schema::hasColumns('material_invoices', [
            'id',
            'material_invoice_code',
            'created_at',
            'updated_at',
        ]));

        $this->assertTrue(Schema::hasColumns('material_items', [
            'id',
            'material_id',
            'material_invoice_id',
            'roll_quantity',
            'weight',
            'created_at',
            'updated_at',
        ]));
    }

    public function test_order_material_invoice_and_material_item_factories_create_relationships()
    {
        $client = Client::factory()->create();
        $order = Order::factory()->create([
            'client_id' => $client->id,
        ]);
        $material = Material::factory()->create([
            'order_id' => $order->id,
        ]);
        $materialInvoice = MaterialInvoice::factory()->create();
        $materialItem = MaterialItem::factory()->create([
            'material_id' => $material->id,
            'material_invoice_id' => $materialInvoice->id,
        ]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'client_id' => $client->id,
        ]);
        $this->assertDatabaseHas('materials', [
            'id' => $material->id,
            'order_id' => $order->id,
        ]);
        $this->assertDatabaseHas('material_invoices', [
            'id' => $materialInvoice->id,
        ]);
        $this->assertDatabaseHas('material_items', [
            'id' => $materialItem->id,
            'material_id' => $material->id,
            'material_invoice_id' => $materialInvoice->id,
        ]);

        $this->assertTrue($order->client->is($client));
        $this->assertTrue($client->orders()->whereKey($order->id)->exists());
        $this->assertTrue($order->materials()->whereKey($material->id)->exists());
        $this->assertTrue($material->order->is($order));
        $this->assertTrue($material->materialItems()->whereKey($materialItem->id)->exists());
        $this->assertTrue($materialInvoice->materialItems()->whereKey($materialItem->id)->exists());
        $this->assertTrue($materialItem->material->is($material));
        $this->assertTrue($materialItem->materialInvoice->is($materialInvoice));
    }
}
