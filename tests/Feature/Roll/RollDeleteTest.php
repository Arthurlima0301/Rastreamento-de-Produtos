<?php

use App\Livewire\ItemMaterials\ItemMaterialRolls;
use App\Livewire\ItemMaterials\ItemMaterialShow;
use App\Models\ItemMaterial;
use App\Models\Load;
use App\Models\Roll;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class RollDeleteTest extends TestCase
{
    use RefreshDatabase;

    // Test that the item material page used to delete rolls can be rendered.
    public function test_item_material_show_page_can_be_rendered_rolls()
    {
        $itemMaterial = ItemMaterial::factory()->create();
        $roll = Roll::factory()->create([
            'item_material_id' => $itemMaterial->id,
        ]);

        $response = $this->get(route('item-materials.show', $itemMaterial));

        $response->assertStatus(200);
        $response->assertSee($roll->label);
    }

    // Test that a roll without a load can be deleted.
    public function test_roll_can_be_deleted()
    {
        $itemMaterial = ItemMaterial::factory()->create();

        $roll = Roll::factory()->create([
            'item_material_id' => $itemMaterial->id,
            'load_id' => null,
        ]);

        Livewire::test(ItemMaterialRolls::class, ['itemMaterialId' => $itemMaterial->id])
            ->call('deleteRoll', $roll)
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('rolls', [
            'id' => $roll->id,
        ]);
    }

    // Test that a roll linked to a load cannot be deleted.
    public function test_roll_cannot_be_deleted_when_it_has_load()
    {
        $itemMaterial = ItemMaterial::factory()->create();
        $load = Load::factory()->create();

        $roll = Roll::factory()->create([
            'item_material_id' => $itemMaterial->id,
            'load_id' => $load->id,
            'status' => 'CORTADA',
        ]);

        Livewire::test(ItemMaterialRolls::class, ['itemMaterialId' => $itemMaterial->id])
            ->call('deleteRoll', $roll)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('rolls', [
            'id' => $roll->id,
            'load_id' => $load->id,
        ]);
    }
}
