<?php

namespace Tests\Feature;

use App\Livewire\ItemMaterials\ItemMaterialShow;
use App\Livewire\Rolls\RollEdit;
use App\Livewire\Rolls\RollsCreate;
use App\Models\ItemMaterial;
use App\Models\Roll;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class RollCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_roll(): void
    {
        $itemMaterial = ItemMaterial::factory()->create();

        Livewire::test(RollsCreate::class, ['itemMaterial' => $itemMaterial])
            ->set('roll_batch', '007202026')
            ->set('roll_vol', '0004')
            ->set('roll_weight', 100)
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('rolls', [
            'label' => '007202026-0004',
            'item_material_id' => $itemMaterial->id,
            'weight' => 100,
            'status' => 'EM_ESTOQUE',
        ]);
    }

    public function test_do_not_create_roll_with_invalid_data(): void
    {
        $itemMaterial = ItemMaterial::factory()->create();

        Livewire::test(RollsCreate::class, ['itemMaterial' => $itemMaterial])
            ->set('roll_batch', '007')
            ->set('roll_vol', '4')
            ->set('roll_weight', 99)
            ->call('save')
            ->assertHasErrors([
                'roll_batch' => 'min',
                'roll_vol' => 'min',
                'roll_weight' => 'min',
            ]);

        $this->assertDatabaseMissing('rolls', [
            'label' => '007-4',
            'item_material_id' => $itemMaterial->id,
        ]);
    }

    public function test_do_not_create_duplicate_roll_label(): void
    {
        $itemMaterial = ItemMaterial::factory()->create();

        Roll::factory()->create([
            'label' => '007202026-0004',
        ]);

        Livewire::test(RollsCreate::class, ['itemMaterial' => $itemMaterial])
            ->set('roll_batch', '007202026')
            ->set('roll_vol', '0004')
            ->set('roll_weight', 100)
            ->call('save')
            ->assertHasErrors([
                'roll_label' => 'unique',
            ]);

        $this->assertDatabaseCount('rolls', 1);
    }

    public function test_access_roll_create_page(): void
    {
        $itemMaterial = ItemMaterial::factory()->create();

        $response = $this->get(route('roll.create', $itemMaterial));

        $response->assertStatus(200);
        $response->assertSee('Adicionar Bobinas');
    }

    public function test_access_roll_edit_page(): void
    {
        $roll = Roll::factory()->create([
            'label' => '007202026-0004',
            'weight' => 100,
        ]);

        $response = $this->get(route('rolls.edit', $roll));

        $response->assertStatus(200);
        $response->assertSee('Editar Bobina');
        $response->assertSee('007202026-0004');
    }

    public function test_update_roll(): void
    {
        $roll = Roll::factory()->create([
            'label' => '007202026-0004',
            'weight' => 100,
            'status' => 'EM_ESTOQUE',
        ]);

        Livewire::test(RollEdit::class, ['roll' => $roll])
            ->set('roll_label', '007202027-0005')
            ->set('roll_weight', 120)
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('rolls', [
            'id' => $roll->id,
            'label' => '007202027-0005',
            'weight' => 120,
            'status' => 'EM_ESTOQUE',
        ]);
    }

    public function test_do_not_update_roll_with_duplicate_label(): void
    {
        Roll::factory()->create([
            'label' => '007202026-0004',
        ]);

        $roll = Roll::factory()->create([
            'label' => '007202026-0005',
            'weight' => 100,
        ]);

        Livewire::test(RollEdit::class, ['roll' => $roll])
            ->set('roll_label', '007202026-0004')
            ->set('roll_weight', 100)
            ->call('save')
            ->assertHasErrors([
                'roll_label' => 'unique',
            ]);

        $this->assertDatabaseHas('rolls', [
            'id' => $roll->id,
            'label' => '007202026-0005',
        ]);
    }

    public function test_filter_rolls_by_status(): void
    {
        $itemMaterial = ItemMaterial::factory()->create();

        Roll::factory()->create([
            'label' => '007202026-0001',
            'status' => 'EM_ESTOQUE',
            'item_material_id' => $itemMaterial->id,
        ]);

        Roll::factory()->create([
            'label' => '007202026-0002',
            'status' => 'CORTADA',
            'item_material_id' => $itemMaterial->id,
        ]);

        Livewire::test(ItemMaterialShow::class, ['itemMaterial' => $itemMaterial])
            ->set('filter_status', 'EM_ESTOQUE')
            ->assertSee('007202026-0001')
            ->assertDontSee('007202026-0002');
    }

    public function test_filter_rolls_by_search_prefix(): void
    {
        $itemMaterial = ItemMaterial::factory()->create();

        Roll::factory()->create([
            'label' => '007202026-0001',
            'item_material_id' => $itemMaterial->id,
        ]);

        Roll::factory()->create([
            'label' => '007202026-0002',
            'item_material_id' => $itemMaterial->id,
        ]);

        Livewire::test(ItemMaterialShow::class, ['itemMaterial' => $itemMaterial])
            ->set('search', '007202026-0001')
            ->assertSee('007202026-0001')
            ->assertDontSee('007202026-0002');
    }

    public function test_delete_roll(): void
    {
        $itemMaterial = ItemMaterial::factory()->create();

        $roll = Roll::factory()->create([
            'label' => '007202026-0001',
            'item_material_id' => $itemMaterial->id,
        ]);

        Livewire::test(ItemMaterialShow::class, ['itemMaterial' => $itemMaterial])
            ->call('deleteRoll', $roll->id)
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('rolls', [
            'id' => $roll->id,
        ]);
    }
}
