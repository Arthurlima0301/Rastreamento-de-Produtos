<?php

use App\Livewire\Rolls\RollsCreate;
use App\Models\ItemMaterial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class RollCreateTest extends TestCase
{
    use RefreshDatabase;

    // Test that the roll creation page can be rendered.
    public function test_roll_create_page_can_be_rendered()
    {
        $itemMaterial = ItemMaterial::factory()->create();

        $response = $this->get(route('roll.create', $itemMaterial));

        $response->assertStatus(200);
        $response->assertSee('Adicionar Bobinas');
        $response->assertSee($itemMaterial->material->paper);
    }

    // Test that a roll is created and linked to the item material.
    public function test_roll_can_be_created_and_associated_with_item_material()
    {
        $itemMaterial = ItemMaterial::factory()->create();

        Livewire::test(RollsCreate::class, ['itemMaterial' => $itemMaterial])
            ->set('rollBatch', '007202026')
            ->set('rollVolume', '0004')
            ->set('rollWeight', 100)
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('rolls', [
            'label' => '007202026-0004',
            'item_material_id' => $itemMaterial->id,
            'weight' => 100,
        ]);
    }

    // Test that a newly created roll is stored in stock.
    public function test_roll_status_is_in_stock_after_creation()
    {
        $itemMaterial = ItemMaterial::factory()->create();

        Livewire::test(RollsCreate::class, ['itemMaterial' => $itemMaterial])
            ->set('rollBatch', '007202026')
            ->set('rollVolume', '0005')
            ->set('rollWeight', 120)
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('rolls', [
            'label' => '007202026-0005',
            'status' => 'EM_ESTOQUE',
        ]);
    }

    // Test validation errors when roll creation fields are invalid.
    public function test_roll_creation_validation_errors()
    {
        $itemMaterial = ItemMaterial::factory()->create();

        Livewire::test(RollsCreate::class, ['itemMaterial' => $itemMaterial])
            ->set('rollBatch', '007')
            ->set('rollVolume', '4')
            ->set('rollWeight', 99)
            ->call('save')
            ->assertHasErrors([
                'rollBatch' => 'min',
                'rollVolume' => 'min',
                'rollWeight' => 'min',
            ]);

        $this->assertDatabaseMissing('rolls', [
            'label' => '007-4',
        ]);
    }
}
