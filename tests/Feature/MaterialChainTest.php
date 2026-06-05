<?php

namespace Tests\Feature;

use App\Livewire\Materials\MaterialCreate;
use App\Models\ItemMaterial;
use App\Models\Material;
use App\Models\MaterialInvoice;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MaterialChainTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_material_with_valid_data(): void
    {
        $order = Order::factory()->create();

        Livewire::test(MaterialCreate::class, ['order' => $order])
            ->set('materials', [$this->validMaterialData()])
            ->call('saveAll')
            ->assertHasNoErrors()
            ->assertRedirect(route('orders.show', $order));

        $this->assertDatabaseHas('materials', [
            'order_id' => $order->id,
            'item_number' => '10',
            'paper' => 'Kraft',
        ]);
    }

    public function test_do_not_create_material_with_invalid_data(): void
    {
        $order = Order::factory()->create();

        Livewire::test(MaterialCreate::class, ['order' => $order])
            ->set('materials', [[]])
            ->call('saveAll')
            ->assertHasErrors([
                'materials.0.item_number',
                'materials.0.shipment_code',
                'materials.0.paper',
            ]);
    }

    public function test_material_belongs_to_order(): void
    {
        $order = Order::factory()->create();

        $material = Material::factory()->create([
            'order_id' => $order->id,
        ]);

        $this->assertTrue($material->order->is($order));
    }

    public function test_material_invoice_has_item_materials(): void
    {
        $material = Material::factory()->create([
            'item_number' => 30,
            'shipment_code' => 1001,
            'roll' => 2,
            'width' => 70,
            'length' => 120,
            'sheets' => 500,
            'grammage' => 250.5,
            'expedition_code' => 777001,
            'paper' => 'Offset',
            'return_batch' => 9001,
            'packages' => 12,
            'package_net_weight' => 1200.75,
            'package_gross_weight' => 1300.8,
        ]);

        $materialInvoice = MaterialInvoice::factory()->create([
            'invoice_code' => '987654',
            'issued_at' => '2026-05-29',
        ]);

        ItemMaterial::factory()->create([
            'material_id' => $material->id,
            'material_invoice_id' => $materialInvoice->id,
        ]);

        $response = $this->get(route('material-invoices.show', $materialInvoice));

        $response->assertStatus(200);
        $response->assertSee('987.654');
        $response->assertSee('29/05/2026');
        $response->assertSee('1001');
        $response->assertSee('Offset');
        $response->assertSee('250,50');
        $response->assertSee('777001');
        $response->assertSee('9001');
        $response->assertSee('1.200,75');
        $response->assertSee('1.300,80');
        $this->assertCount(1, $materialInvoice->itemMaterials);
    }

    public function test_list_item_materials(): void
    {
        $material = Material::factory()->create([
            'item_number' => 40,
            'shipment_code' => 2001,
            'roll' => 3,
            'width' => 80,
            'length' => 130,
            'sheets' => 600,
            'grammage' => 180.25,
            'expedition_code' => 888001,
            'paper' => 'Cartao',
            'return_batch' => 9010,
            'packages' => 8,
            'package_net_weight' => 900.5,
            'package_gross_weight' => 950.75,
        ]);

        $materialInvoice = MaterialInvoice::factory()->create([
            'invoice_code' => '111222',
        ]);

        ItemMaterial::factory()->create([
            'number' => 5,
            'material_id' => $material->id,
            'material_invoice_id' => $materialInvoice->id,
        ]);

        $response = $this->get('/item-materials');

        $response->assertStatus(200);
        $response->assertSee('Cartao');
        $response->assertSee('180,25');
        $response->assertSee('888001');
        $response->assertSee('9010');
        $response->assertSee('111.222');
    }

    private function validMaterialData(): array
    {
        return [
            'item_number' => '10',
            'shipment_code' => '555001',
            'roll' => 1,
            'width' => 70,
            'length' => 100,
            'sheets' => 500,
            'grammage' => 250.5,
            'expedition_code' => '777001',
            'paper' => 'Kraft',
            'return_batch' => '9001',
            'packages' => 12,
            'package_net_weight' => 1200.75,
            'package_gross_weight' => 1300.8,
        ];
    }
}
