<?php

namespace Tests\Feature\ItemMaterial;

use App\Models\ItemMaterial;
use Livewire\Livewire;
use Tests\TestCase;
use App\Livewire\ItemMaterials\ItemMaterialLosses;
use App\Models\Material;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemMaterialLossesTest extends TestCase
{
    use RefreshDatabase;

    // Test losses component is rendered correctly
    public function test_losses_component_is_rendered_correctly()
    {
        $material = Material::factory()->create([
            'package_net_weight' => 100, // Net weight per pallet
        ]);

        $itemMaterial = ItemMaterial::factory()->create([
            'total_weight' => 1000, // Initial total weight of the item material
            'pallets_quantity' => 10, // Quantity of pallets
            'material_id' => $material->id, // Material ID
        ]);

        Livewire::test(ItemMaterialLosses::class, ['itemMaterial' => $itemMaterial])
        ->assertStatus(200)
        ->assertSee('Calcular Perdas do Item Material')
        ->assertSee($itemMaterial->pallets_quantity)
        ->assertSee(number_format($itemMaterial->total_weight, 2, ',', '.'));
    }


    /** 
     * Test it calculates loss percentage correctly
     */
    public function test_it_calculates_loss_percentage_correctly()
    {
        $material = Material::factory()->create([
            'package_net_weight' => 100, // Net weight per pallet
        ]);

        $itemMaterial = ItemMaterial::factory()->create([
            'total_weight' => 1000, // Initial total weight of the item material
            'material_id' => $material->id, // Material ID
        ]);

        $component = Livewire::test(ItemMaterialLosses::class, ['itemMaterial' => $itemMaterial])
        ->set('palletQuantity', 10)
        ->call('calc');

        $expectedLossPercentage = 0;
        $this->assertEquals($expectedLossPercentage, $component->lossPercentage);
    }

    /** 
     * Test it calculates aparas quantity correctly
     */
    public function test_it_calculates_aparas_quantity_correctly()
    {
        $material = Material::factory()->create([
            'package_net_weight' => 100, // Net weight per pallet
        ]);

        $itemMaterial = ItemMaterial::factory()->create([
            'total_weight' => 1500, // Initial total weight of the item material
            'pallets_quantity' => 10, // Quantity of pallets
            'material_id' => $material->id, // Material ID
        ]);

        $component = Livewire::test(ItemMaterialLosses::class, ['itemMaterial' => $itemMaterial])
        ->set('palletQuantity', 10)
        ->call('calc');

        $expectedAparasQuantity = 500;
        $this->assertEquals($expectedAparasQuantity, $component->wasteQuantity);
    }
}
