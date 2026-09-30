<?php

namespace Tests\Feature\Pallets;

use App\Livewire\Pallets\PalletEdit;
use App\Models\ItemMaterial;
use App\Models\Load;
use App\Models\Material;
use App\Models\Pallet;
use App\Models\Roll;
use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PalletUpdateTest extends TestCase
{
    use RefreshDatabase;
    // Test pallet edit page can be rendered
    public function test_pallet_edit_page_can_be_rendered()
    {
        $pallet = Pallet::factory()->create();

        $response = $this->get(route('pallets.edit', $pallet->id));
        $response->assertStatus(200);
    }

    // Test if pallet label can be updated
    public function test_pallet_label_can_be_updated()
    {
        $pallet = Pallet::factory()->create([
            'label' => 1000,
        ]);

        Livewire::test(PalletEdit::class, ['pallet' => $pallet])
            ->set('palletLabel', 1234)
            ->call('save');

        $this->assertDatabaseHas('pallets', [
            'id' => $pallet->id,
            'label' => 1234,
            'load_id' => $pallet->load_id,
        ]);
    }

    // Test if pallet load can be updated
    public function test_pallet_load_can_be_updated()
    {
        $material = Material::factory()->create([
            'package_net_weight' => 50,
        ]);

        $itemMaterial = ItemMaterial::factory()->create([
            'material_id' => $material->id,
        ]);

        $load1 = Load::factory()->create();

        Roll::factory()->create([
            'status' => 'CORTADA',
            'weight' => 50,
            'load_id' => $load1->id,
            'item_material_id' => $itemMaterial->id,
        ]);

        $pallet = Pallet::factory()->create([
            'load_id' => $load1->id,
            'package_net_weight' => 50,
            'item_material_id' => $itemMaterial->id,
        ]);

        $newLoad = Load::factory()->create();

        Roll::factory()->create([
            'status' => 'CORTADA',
            'weight' => 50,
            'load_id' => $newLoad->id,
            'item_material_id' => $itemMaterial->id,
        ]);

        Livewire::test(PalletEdit::class, ['pallet' => $pallet])
            ->set('cutLoadId', $newLoad->id)
            ->call('save')
            ->assertHasNoErrors();
        
        $this->assertDatabaseHas('pallets', [
            'id' => $pallet->id,
            'load_id' => $newLoad->id,
        ]);
    }
}
