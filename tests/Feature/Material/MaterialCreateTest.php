<?php

use App\Livewire\Materials\MaterialCreate;
use App\Models\Material;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MaterialCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_material_create_page_can_be_rendered()
    {
        $order = Order::factory()->create([
            'order_code' => 'CUT-100',
        ]);

        $response = $this->get(route('materials.create', $order));

        $response->assertStatus(200);
        $response->assertSee('Adicionar Materiais');
        $response->assertSee('CUT-100');
    }

    public function test_material_can_be_created()
    {
        $order = Order::factory()->create();

        Livewire::test(MaterialCreate::class, ['order' => $order])
            ->set('materials', [$this->validMaterialData()])
            ->call('saveMaterials')
            ->assertHasNoErrors()
            ->assertRedirect(route('orders.show', $order));

        $this->assertDatabaseHas('materials', [
            'order_id' => $order->id,
            'item_number' => '10',
            'shipment_code' => '1001',
            'paper' => 'Kraft',
        ]);
    }

    public function test_material_is_associated_with_order()
    {
        $order = Order::factory()->create([
            'order_code' => 'CUT-200',
        ]);

        $material = Material::factory()->create([
            'order_id' => $order->id,
        ]);

        $this->assertTrue($material->order->is($order));
    }

    private function validMaterialData(): array
    {
        return [
            'item_number' => '10',
            'shipment_code' => '1001',
            'roll' => 1,
            'width' => 70,
            'length' => 100,
            'sheets' => 500,
            'grammage' => 250.5,
            'expedition_code' => '777001',
            'paper' => 'Kraft',
            'return_batch' => 'RET-1001',
            'packages' => 12,
            'package_net_weight' => 1200.75,
            'package_gross_weight' => 1300.8,
        ];
    }
}
