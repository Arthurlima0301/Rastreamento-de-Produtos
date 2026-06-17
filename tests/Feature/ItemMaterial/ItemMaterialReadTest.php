<?php

use App\Livewire\ItemMaterials\ItemMaterialTable;
use App\Models\ItemMaterial;
use App\Models\Material;
use App\Models\MaterialInvoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ItemMaterialReadTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_material_index_page_can_be_rendered()
    {
        $response = $this->get(route('item-materials.index'));

        $response->assertStatus(200);
        $response->assertSee('Itens de Material');
        $response->assertSee('item-materials.item-material-table');
    }

    public function test_item_material_all_data_is_displayed()
    {
        $material = Material::factory()->create([
            'paper' => 'Cartao',
            'grammage' => 180.25,
            'expedition_code' => 888001,
            'return_batch' => 'RET-ITEM-1',
        ]);

        $materialInvoice = MaterialInvoice::factory()->create([
            'invoice_code' => '111222',
            'issued_at' => '2026-06-01',
        ]);

        ItemMaterial::factory()->create([
            'number' => 5,
            'material_id' => $material->id,
            'material_invoice_id' => $materialInvoice->id,
            'total_weight' => 24,
        ]);

        $response = $this->get(route('item-materials.index'));

        $response->assertSee('Cartao');
        $response->assertSee('180,25');
        $response->assertSee('888001');
        $response->assertSee('RET-ITEM-1');
        $response->assertSee('111.222');
        $response->assertSee('24,00');
    }

    public function test_item_material_search_functionality()
    {
        $matchedMaterial = Material::factory()->create([
            'paper' => 'Cartao',
            'return_batch' => 'RET-ITEM-2',
        ]);

        $otherMaterial = Material::factory()->create([
            'paper' => 'Offset',
            'return_batch' => 'RET-ITEM-3',
        ]);

        ItemMaterial::factory()->create([
            'material_id' => $matchedMaterial->id,
        ]);

        ItemMaterial::factory()->create([
            'material_id' => $otherMaterial->id,
        ]);

        Livewire::test(ItemMaterialTable::class)
            ->set('search', 'Car')
            ->assertSee('Cartao')
            ->assertDontSee('Offset');
    }
}
