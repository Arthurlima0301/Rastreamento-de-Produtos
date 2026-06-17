<?php

use App\Models\Material;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaterialUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_show_page_with_material_can_be_rendered()
    {
        $order = Order::factory()->create([
            'order_code' => 'CUT-500',
        ]);

        Material::factory()->create([
            'order_id' => $order->id,
            'paper' => 'Kraft',
        ]);

        $response = $this->get(route('orders.show', $order));

        $response->assertStatus(200);
        $response->assertSee('CUT-500');
        $response->assertSee('Kraft');
    }

    public function test_material_can_be_updated()
    {
        $material = Material::factory()->create([
            'paper' => 'Kraft',
            'return_batch' => 'RET-500',
        ]);

        $material->update([
            'paper' => 'Offset Atualizado',
            'return_batch' => 'RET-501',
            'packages' => 20,
        ]);

        $this->assertDatabaseHas('materials', [
            'id' => $material->id,
            'paper' => 'Offset Atualizado',
            'return_batch' => 'RET-501',
            'packages' => 20,
        ]);

        $this->assertDatabaseMissing('materials', [
            'id' => $material->id,
            'paper' => 'Kraft',
            'return_batch' => 'RET-500',
        ]);
    }
}
