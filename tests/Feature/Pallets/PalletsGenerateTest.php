<?php

namespace Tests\Feature\Pallets;

use App\Livewire\ItemMaterials\ItemMaterialShow;
use App\Models\ItemMaterial;
use App\Models\Load;
use App\Models\Material;
use App\Models\Roll;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

class PalletsGenerateTest extends TestCase
{
    use RefreshDatabase;


    // Item Material Show can be rendered
    public function test_item_material_show_can_be_rendered()
    {
        $itemMaterial = ItemMaterial::factory()->create([
            'total_weight' => 100,
        ]);

        Livewire::test(ItemMaterialShow::class, ['itemMaterial' => $itemMaterial])
            ->assertHasNoErrors()
            ->assertSee(100, 00);
    }

    // Pallet Generate is successful generated
    public function test_pallet_generate_is_successful()
    {
        $material = Material::factory()->create([
            'package_net_weight' => 50,
        ]);

        $itemMaterial = ItemMaterial::factory()->create([
            'total_weight' => 100,
            'material_id' => $material->id,
            'pallets_quantity' => 2,
        ]);

        $load = Load::factory()->create();

        Roll::factory()->count(2)->create([
            'weight' => 50,
            'status' => 'EM_ESTOQUE',
            'load_id' => $load->id,
            'item_material_id' => $itemMaterial->id,
        ]);

        Livewire::test(ItemMaterialShow::class, ['itemMaterial' => $itemMaterial])
            ->call('generatePallets')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('pallets', [
            'label' => 1,
            'item_material_id' => $itemMaterial->id,
            'load_id' => $load->id,
            'package_net_weight' => 50,
        ]);

        $this->assertDatabaseHas('pallets', [
            'label' => 2,
            'item_material_id' => $itemMaterial->id,
            'load_id' => $load->id,
            'package_net_weight' => 50,
        ]);
    }


    // Test if pallet label is incremented correctly
    public function test_pallet_label_is_incremented_correctly()
    {
        $material = Material::factory()->create([
            'package_net_weight' => 50,
        ]);

        $itemMaterial = ItemMaterial::factory()->create([
            'total_weight' => 100,
            'material_id' => $material->id,
            'pallets_quantity' => 2,
        ]);

        $load = Load::factory()->create();

        Roll::factory()->count(2)->create([
            'weight' => 50,
            'status' => 'CORTADA',
            'load_id' => $load->id,
            'item_material_id' => $itemMaterial->id,
        ]);

        Livewire::test(ItemMaterialShow::class, ['itemMaterial' => $itemMaterial])
            ->call('generatePallets')
            ->assertHasNoErrors();

        $this->assertDatabaseCount('pallets', 2);
        $this->assertDatabaseHas('pallets', [
            'label' => 1,
            'item_material_id' => $itemMaterial->id,
            'load_id' => $load->id,
            'package_net_weight' => 50,
        ]);

        $this->assertDatabaseHas('pallets', [
            'label' => 2,
            'item_material_id' => $itemMaterial->id,
            'load_id' => $load->id,
            'package_net_weight' => 50,
        ]);

        // Generate pallets for the second item material
        $material2 = Material::factory()->create([
            'package_net_weight' => 50,
        ]);

        $itemMaterial2 = ItemMaterial::factory()->create([
            'total_weight' => 100,
            'material_id' => $material2->id,
            'pallets_quantity' => 2,
        ]);

        $load2 = Load::factory()->create();

        Roll::factory()->count(2)->create([
            'weight' => 50,
            'status' => 'CORTADA',
            'load_id' => $load2->id,
            'item_material_id' => $itemMaterial2->id,
        ]);

        Livewire::test(ItemMaterialShow::class, ['itemMaterial' => $itemMaterial2])
            ->refresh()
            ->call('generatePallets')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('pallets', [
            'label' => 1,
            'item_material_id' => $itemMaterial2->id,
            'load_id' => $load2->id,
            'package_net_weight' => 50,
        ]);
    }


    // Test if pallet generation fails when there dont have pallets quantity defined
    public function test_pallet_generation_fails_when_no_pallets_quantity_defined()
    {
        $material = Material::factory()->create([
            'package_net_weight' => 50,
        ]);

        $itemMaterial = ItemMaterial::factory()->create([
            'total_weight' => 100,
            'material_id' => $material->id,
            'pallets_quantity' => 0,
        ]);

        $load = Load::factory()->create();

        Roll::factory()->count(2)->create([
            'weight' => 50,
            'status' => 'CORTADA',
            'load_id' => $load->id,
            'item_material_id' => $itemMaterial->id,
        ]);

        Livewire::test(ItemMaterialShow::class, ['itemMaterial' => $itemMaterial])
            ->call('generatePallets')
            ->assertHasErrors();

        $this->assertDatabaseCount('pallets', 0);
    }


    // Test if pallet generation fails when rolls weight sum is different from item material total weight
    public function test_pallet_generation_fails_when_rolls_weight_sum_is_different_from_item_material_total_weight()
    {
        $material = Material::factory()->create([
            'package_net_weight' => 50,
        ]);

        $itemMaterial = ItemMaterial::factory()->create([
            'total_weight' => 100,
            'material_id' => $material->id,
            'pallets_quantity' => 2,
        ]);

        $load = Load::factory()->create();

        Roll::factory()->count(2)->create([
            'weight' => 30,
            'status' => 'CORTADA',
            'load_id' => $load->id,
            'item_material_id' => $itemMaterial->id,
        ]);

        Livewire::test(ItemMaterialShow::class, ['itemMaterial' => $itemMaterial])
            ->call('generatePallets')
            ->assertHasErrors();

        $this->assertDatabaseCount('pallets', 0);
    }

    // Test if pallet generation fails when there is no load with sufficient balance
    public function test_pallet_generation_fails_when_no_load_with_sufficient_balance()
    {
        $material = Material::factory()->create([
            'package_net_weight' => 50,
        ]);

        $itemMaterial = ItemMaterial::factory()->create([
            'total_weight' => 100,
            'material_id' => $material->id,
            'pallets_quantity' => 2,
        ]);

        Livewire::test(ItemMaterialShow::class, ['itemMaterial' => $itemMaterial])
            ->call('generatePallets')
            ->assertHasErrors();

        $this->assertDatabaseCount('pallets', 0);
    }

    // Test if pallet generation fails when there is load with sufficient balance was already used to generate the maximum number of pallets
    public function test_pallet_generation_fails_when_load_with_sufficient_balance_was_already_used()
    {
        $material = Material::factory()->create([
            'package_net_weight' => 50,
        ]);

        $itemMaterial = ItemMaterial::factory()->create([
            'total_weight' => 100,
            'material_id' => $material->id,
            'pallets_quantity' => 2,
        ]);

        $load = Load::factory()->create();

        Roll::factory()->count(2)->create([
            'weight' => 50,
            'status' => 'CORTADA',
            'load_id' => $load->id,
            'item_material_id' => $itemMaterial->id,
        ]);

        Livewire::test(ItemMaterialShow::class, ['itemMaterial' => $itemMaterial])
            ->call('generatePallets')
            ->assertHasNoErrors();

        Livewire::test(ItemMaterialShow::class, ['itemMaterial' => $itemMaterial])
            ->call('generatePallets')
            ->assertHasErrors();

        $this->assertDatabaseCount('pallets', 2);
    }


    // Test no more pallets can be generated when the maximum number of pallets is reached
    public function test_no_more_pallets_can_be_generated_when_maximum_number_of_pallet()
    {
        $material = Material::factory()->create([
            'package_net_weight' => 50,
        ]);

        $itemMaterial = ItemMaterial::factory()->create([
            'total_weight' => 150,
            'material_id' => $material->id,
            'pallets_quantity' => 2,
        ]);

        $load = Load::factory()->create();
        Roll::factory()->count(3)->create([
            'weight' => 50,
            'status' => 'CORTADA',
            'load_id' => $load->id,
            'item_material_id' => $itemMaterial->id,
        ]);

        Livewire::test(ItemMaterialShow::class, ['itemMaterial' => $itemMaterial])
            ->call('generatePallets')
            ->assertHasNoErrors();

        Livewire::test(ItemMaterialShow::class, ['itemMaterial' => $itemMaterial])
            ->call('generatePallets')
            ->assertHasErrors();

        $this->assertDatabaseCount('pallets', 2);

    }
}
