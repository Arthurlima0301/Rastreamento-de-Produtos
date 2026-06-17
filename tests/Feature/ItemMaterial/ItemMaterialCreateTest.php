<?php

use App\Livewire\ItemMaterials\ItemMaterialShow;
use App\Models\ItemMaterial;
use App\Models\Material;
use App\Models\MaterialInvoice;
use App\Models\Order;
use App\Models\Roll;
use App\Services\MaterialInvoices\ExtractMaterialItems;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ItemMaterialCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_material_invoice_page_can_be_rendered()
    {
        $response = $this->get(route('material-invoices.index'));

        $response->assertStatus(200);
        $response->assertSee('Notas Fiscais de Materiais');
    }

    public function test_item_material_can_be_created_from_xml_items()
    {
        $order = Order::factory()->create([
            'status' => 'ATIVA',
        ]);

        $material = Material::factory()->create([
            'order_id' => $order->id,
            'shipment_code' => 1001,
            'paper' => 'Kraft',
        ]);

        $materialInvoice = MaterialInvoice::factory()->create();

        (new ExtractMaterialItems)->extract($this->xmlFixture(), $materialInvoice->id);

        $this->assertDatabaseHas('item_material', [
            'number' => 1,
            'material_invoice_id' => $materialInvoice->id,
            'material_id' => $material->id,
            'total_weight' => 24,
        ]);
    }

    public function test_imported_item_material_data_matches_xml()
    {
        $order = Order::factory()->create([
            'status' => 'ATIVA',
        ]);

        $material = Material::factory()->create([
            'order_id' => $order->id,
            'shipment_code' => 1001,
            'paper' => 'Kraft',
        ]);

        $materialInvoice = MaterialInvoice::factory()->create();

        (new ExtractMaterialItems)->extract($this->xmlFixture(), $materialInvoice->id);

        $itemMaterial = ItemMaterial::query()->firstOrFail();

        $this->assertSame(1, $itemMaterial->number);
        $this->assertSame($materialInvoice->id, $itemMaterial->material_invoice_id);
        $this->assertSame($material->id, $itemMaterial->material_id);
        $this->assertEquals(24, $itemMaterial->total_weight);
    }

    public function test_item_material_is_imported_from_latest_active_order()
    {
        $oldOrder = Order::factory()->create([
            'status' => 'ATIVA',
            'created_at' => now()->subDay(),
        ]);

        $latestOrder = Order::factory()->create([
            'status' => 'ATIVA',
            'created_at' => now(),
        ]);

        Material::factory()->create([
            'order_id' => $oldOrder->id,
            'shipment_code' => 1001,
            'paper' => 'Kraft Antigo',
            'return_batch' => 'RET-OLD',
        ]);

        $latestMaterial = Material::factory()->create([
            'order_id' => $latestOrder->id,
            'shipment_code' => 1001,
            'paper' => 'Kraft Novo',
            'return_batch' => 'RET-NEW',
        ]);

        $materialInvoice = MaterialInvoice::factory()->create();

        (new ExtractMaterialItems)->extract($this->xmlFixture(), $materialInvoice->id);

        $this->assertDatabaseHas('item_material', [
            'material_invoice_id' => $materialInvoice->id,
            'material_id' => $latestMaterial->id,
        ]);
    }

    public function test_item_material_is_imported_only_from_active_order()
    {
        $activeOrder = Order::factory()->create([
            'status' => 'ATIVA',
            'created_at' => now()->subDay(),
        ]);

        $inactiveOrder = Order::factory()->create([
            'status' => 'FINALIZADA',
            'created_at' => now(),
        ]);

        $activeMaterial = Material::factory()->create([
            'order_id' => $activeOrder->id,
            'shipment_code' => 1001,
            'paper' => 'Kraft Ativo',
            'return_batch' => 'RET-ACTIVE',
        ]);

        $inactiveMaterial = Material::factory()->create([
            'order_id' => $inactiveOrder->id,
            'shipment_code' => 1001,
            'paper' => 'Kraft Finalizado',
            'return_batch' => 'RET-INACTIVE',
        ]);

        $materialInvoice = MaterialInvoice::factory()->create();

        (new ExtractMaterialItems)->extract($this->xmlFixture(), $materialInvoice->id);

        $this->assertDatabaseHas('item_material', [
            'material_invoice_id' => $materialInvoice->id,
            'material_id' => $activeMaterial->id,
        ]);

        $this->assertDatabaseMissing('item_material', [
            'material_invoice_id' => $materialInvoice->id,
            'material_id' => $inactiveMaterial->id,
        ]);
    }

    public function test_roll_sum_is_shown_in_red_when_it_differs_from_item_material_quantity()
    {
        $itemMaterial = ItemMaterial::factory()->create([
            'total_weight' => 300,
        ]);

        Roll::factory()->create([
            'item_material_id' => $itemMaterial->id,
            'weight' => 100,
            'status' => 'EM_ESTOQUE',
        ]);

        Livewire::test(ItemMaterialShow::class, ['itemMaterial' => $itemMaterial])
            ->assertSee('Peso Total')
            ->assertSee('100,00')
            ->assertSeeHtml('class="text-red-500"');
    }

    private function xmlFixture(): SimpleXMLElement
    {
        return simplexml_load_file(base_path('tests/Fixtures/nota_fiscal_valida.xml'));
    }
}
