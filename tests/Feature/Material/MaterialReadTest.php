<?php

use App\Livewire\ItemMaterials\ItemMaterialEdit;
use App\Models\ItemMaterial;
use App\Models\Material;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MaterialReadTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_show_page_with_materials_can_be_rendered()
    {
        $order = Order::factory()->create([
            'order_code' => 'CUT-300',
        ]);

        $response = $this->get(route('orders.show', $order));

        $response->assertStatus(200);
        $response->assertSee('Detalhes da Ordem de Corte');
        $response->assertSee('CUT-300');
    }

    public function test_material_all_data_is_displayed()
    {
        $order = Order::factory()->create([
            'order_code' => 'CUT-400',
        ]);

        Material::factory()->create([
            'order_id' => $order->id,
            'item_number' => 10,
            'shipment_code' => 1001,
            'roll' => 2,
            'width' => 70,
            'length' => 120,
            'sheets' => 500,
            'grammage' => 250.5,
            'expedition_code' => 777001,
            'paper' => 'Kraft',
            'return_batch' => 'RET-400',
            'packages' => 12,
            'package_net_weight' => 1200.75,
            'package_gross_weight' => 1300.8,
        ]);

        $response = $this->get(route('orders.show', $order));

        $response->assertSee('CUT-400');
        $response->assertSee('Kraft');
        $response->assertSee('1001');
        $response->assertSee('250,50');
        $response->assertSee('1.200,75');
        $response->assertSee('1.300,80');
    }

    public function test_material_search_functionality()
    {
        $matchedMaterial = Material::factory()->create([
            'paper' => 'Kraft',
            'return_batch' => 'RET-SEARCH-1',
        ]);

        Material::factory()->create([
            'paper' => 'Offset',
            'return_batch' => 'RET-SEARCH-2',
        ]);

        $itemMaterial = ItemMaterial::factory()->create([
            'material_id' => $matchedMaterial->id,
        ]);

        Livewire::test(ItemMaterialEdit::class, ['itemMaterial' => $itemMaterial])
            ->set('search', 'Kra')
            ->assertSee('Kraft')
            ->assertDontSee('Offset');
    }
}
