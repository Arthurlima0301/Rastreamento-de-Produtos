<?php

use App\Livewire\Materials\MaterialEdit;
use App\Livewire\Orders\OrderShow;
use App\Models\ItemMaterial;
use App\Models\Material;
use App\Models\Order;
use App\Models\Pallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MaterialUpdateTest extends TestCase
{
    use RefreshDatabase;

    // Test to ensure that the material edit page can be rendered successfully
    public function test_material_edit_page_can_be_rendered()
    {
        $order = Order::factory()->create([
            'order_code' => 'CUT-700',
        ]);

        $material = Material::factory()->create([
            'order_id' => $order->id,
            'paper' => 'Kraft',
            'return_batch' => 'RET-700',
        ]);

        $response = $this->get(route('materials.edit', $material));

        $response->assertStatus(200);
        $response->assertSee('Editar Material');
        $response->assertSee('CUT-700');
        $response->assertSee('Kraft');
    }

    // Test to ensure that the order show page displays the material edit link when material actions are open
    public function test_order_show_displays_material_edit_link_when_material_actions_are_open()
    {
        $order = Order::factory()->create();

        $material = Material::factory()->create([
            'order_id' => $order->id,
        ]);

        Livewire::test(OrderShow::class, ['order' => $order])
            ->call('editMaterial', $material->id)
            ->assertSee(route('materials.edit', $material), false);
    }

    // Test to ensure that a material can be updated successfully
    public function test_material_can_be_updated()
    {
        $order = Order::factory()->create();

        $material = Material::factory()->create([
            'order_id' => $order->id,
            'paper' => 'Kraft',
            'shipment_code' => 7001,
            'return_batch' => 'RET-701',
            'packages' => 12,
        ]);

        Livewire::test(MaterialEdit::class, ['material' => $material])
            ->set('form.paper', 'Offset Atualizado')
            ->set('form.packages', 20)
            ->call('saveEdit')
            ->assertHasNoErrors()
            ->assertRedirect(route('orders.show', $order));

        $this->assertDatabaseHas('materials', [
            'id' => $material->id,
            'paper' => 'Offset Atualizado',
            'shipment_code' => 7001,
            'return_batch' => 'RET-701',
            'packages' => 20,
        ]);

        $this->assertDatabaseMissing('materials', [
            'id' => $material->id,
            'paper' => 'Kraft',
            'packages' => 12,
        ]);
    }

    // Test to ensure that a material cannot be updated with a duplicated return_batch
    public function test_material_cannot_be_updated_with_duplicated_return_batch()
    {
        $material = Material::factory()->create([
            'paper' => 'Kraft',
            'return_batch' => 'RET-702',
        ]);

        Material::factory()->create([
            'return_batch' => 'RET-703',
        ]);

        Livewire::test(MaterialEdit::class, ['material' => $material])
            ->set('form.return_batch', 'RET-703')
            ->call('saveEdit')
            ->assertHasErrors(['form.return_batch' => 'unique']);

        $this->assertDatabaseHas('materials', [
            'id' => $material->id,
            'paper' => 'Kraft',
            'return_batch' => 'RET-702',
        ]);
    }

    // Test to ensure that a material cannot be updated if it has item materials with pallets associated
    public function test_material_cannot_be_updated_if_it_has_item_materials_with_pallets()
    {
        $material = Material::factory()->create([
            'paper' => 'Kraft',
            'return_batch' => 'RET-500',
            'packages' => 20,
        ]);

        $itemMaterial = ItemMaterial::factory()->create([
            'material_id' => $material->id,
        ]);

        $pallet = Pallet::factory()->create([
            'item_material_id' => $itemMaterial->id,
        ]);

        Livewire::test(MaterialEdit::class, ['material' => $material])
            ->set('form.paper', 'Offset Atualizado')
            ->set('form.return_batch', 'RET-501')
            ->set('form.packages', 25)
            ->call('saveEdit')
            ->assertHasErrors();

        $this->assertDatabaseHas('materials', [
            'id' => $material->id,
            'paper' => 'Kraft',
            'return_batch' => 'RET-500',
            'packages' => 20,
        ]);

        $this->assertDatabaseMissing('materials', [
            'id' => $material->id,
            'paper' => 'Offset Atualizado',
            'return_batch' => 'RET-501',
            'packages' => 25,
        ]);
    }
}
