<?php

use App\Livewire\Orders\OrderShow;
use App\Models\ItemMaterial;
use App\Models\Material;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MaterialDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_show_page_with_material_can_be_rendered()
    {
        $order = Order::factory()->create([
            'order_code' => 'CUT-600',
        ]);

        Material::factory()->create([
            'order_id' => $order->id,
            'paper' => 'Kraft',
        ]);

        $response = $this->get(route('orders.show', $order));

        $response->assertStatus(200);
        $response->assertSee('CUT-600');
        $response->assertSee('Kraft');
    }

    public function test_material_can_be_deleted()
    {
        $order = Order::factory()->create();

        $material = Material::factory()->create([
            'order_id' => $order->id,
            'paper' => 'Kraft',
        ]);

        Livewire::test(OrderShow::class, ['order' => $order])
            ->call('removeMaterial', $material)
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('materials', [
            'id' => $material->id,
        ]);
    }

    public function test_material_cannot_be_deleted_when_it_has_item_materials()
    {
        $order = Order::factory()->create();

        $material = Material::factory()->create([
            'order_id' => $order->id,
            'paper' => 'Kraft',
        ]);

        ItemMaterial::factory()->create([
            'material_id' => $material->id,
        ]);

        Livewire::test(OrderShow::class, ['order' => $order])
            ->call('removeMaterial', $material)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('materials', [
            'id' => $material->id,
            'paper' => 'Kraft',
        ]);
    }
}
