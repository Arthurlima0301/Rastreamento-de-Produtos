<?php

use App\Livewire\ItemMaterials\ItemMaterialEdit;
use App\Models\ItemMaterial;
use App\Models\Material;
use App\Models\MaterialInvoice;
use App\Models\Pallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ItemMaterialUpdateTest extends TestCase
{
    use RefreshDatabase;

    // Test that the item material edit page can be rendered with the correct data.
    public function test_item_material_edit_page_can_be_rendered()
    {
        $material = Material::factory()->create([
            'paper' => 'Kraft',
        ]);

        $materialInvoice = MaterialInvoice::factory()->create([
            'invoice_code' => '333444',
        ]);

        $itemMaterial = ItemMaterial::factory()->create([
            'number' => 1,
            'material_id' => $material->id,
            'material_invoice_id' => $materialInvoice->id,
        ]);

        $response = $this->get(route('item-materials.edit', $itemMaterial));

        $response->assertStatus(200);
        $response->assertSee('Substituir Material do Item');
        $response->assertSee('333.444');
        $response->assertSee('Kraft');
    }

    // Test that the material linked to an item can be replaced.
    public function test_item_material_material_can_be_replaced()
    {
        $oldMaterial = Material::factory()->create([
            'paper' => 'Kraft',
            'return_batch' => 'RET-OLD-MATERIAL',
        ]);

        $newMaterial = Material::factory()->create([
            'paper' => 'Offset',
            'return_batch' => 'RET-NEW-MATERIAL',
        ]);

        $materialInvoice = MaterialInvoice::factory()->create();

        $itemMaterial = ItemMaterial::factory()->create([
            'material_id' => $oldMaterial->id,
            'material_invoice_id' => $materialInvoice->id,
        ]);

        Livewire::test(ItemMaterialEdit::class, ['itemMaterial' => $itemMaterial])
            ->call('replaceMaterial', $newMaterial->id)
            ->assertRedirect(route('material-invoices.show', $materialInvoice->id));

        $this->assertDatabaseHas('item_material', [
            'id' => $itemMaterial->id,
            'material_id' => $newMaterial->id,
        ]);

        $this->assertDatabaseMissing('item_material', [
            'id' => $itemMaterial->id,
            'material_id' => $oldMaterial->id,
        ]);
    }

    // Test that the material cannot be replaced if the item has associated pallets.
    public function test_item_material_material_cannot_be_replaced_if_pallets_exist()
    {
        $material = Material::factory()->create([
            'paper' => 'Kraft',
            'return_batch' => '123456',
        ]);

        $materialInvoice = MaterialInvoice::factory()->create();

        $itemMaterial = ItemMaterial::factory()->create([
            'material_id' => $material->id,
            'material_invoice_id' => $materialInvoice->id,
        ]);

        // Create a pallet associated with the item material to simulate existing pallets.
        Pallet::factory()->create([
            'label' => 1,
            'item_material_id' => $itemMaterial->id,
        ]);

        $newMaterial = Material::factory()->create([
            'paper' => 'Offset',
            'return_batch' => 'RET-NEW-MATERIAL',
        ]);

        Livewire::test(ItemMaterialEdit::class, ['itemMaterial' => $itemMaterial])
            ->call('replaceMaterial', $newMaterial->id)
            ->assertSee('Não é possível substituir o material deste item, pois ele já possui pallets associados!');

        $this->assertDatabaseHas('item_material', [
            'id' => $itemMaterial->id,
            'material_id' => $material->id,
        ]);
    }
}
