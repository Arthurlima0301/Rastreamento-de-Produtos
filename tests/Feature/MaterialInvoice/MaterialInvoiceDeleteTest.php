<?php

use App\Livewire\MaterialInvoices\MaterialInvoiceTable;
use App\Models\ItemMaterial;
use App\Models\Load;
use App\Models\MaterialInvoice;
use App\Models\Roll;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MaterialInvoiceDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_material_invoice_index_page_can_be_rendered()
    {
        $response = $this->get(route('material-invoices.index'));

        $response->assertStatus(200);
        $response->assertSee('material-invoices.material-invoice-table');
    }

    public function test_material_invoice_can_be_deleted_with_its_item_materials()
    {
        $materialInvoice = MaterialInvoice::factory()->create([
            'invoice_code' => '777200',
        ]);

        $itemMaterial = ItemMaterial::factory()->create([
            'material_invoice_id' => $materialInvoice->id,
        ]);

        Livewire::test(MaterialInvoiceTable::class)
            ->call('delete', $materialInvoice)
            ->assertRedirect(route('material-invoices.index'));

        $this->assertDatabaseMissing('material_invoice', [
            'id' => $materialInvoice->id,
        ]);

        $this->assertDatabaseMissing('item_material', [
            'id' => $itemMaterial->id,
        ]);
    }

    public function test_material_invoice_cannot_be_deleted_when_item_material_has_loaded_roll()
    {
        $materialInvoice = MaterialInvoice::factory()->create([
            'invoice_code' => '777400',
        ]);

        $itemMaterial = ItemMaterial::factory()->create([
            'material_invoice_id' => $materialInvoice->id,
        ]);

        $load = Load::factory()->create();

        Roll::factory()->create([
            'item_material_id' => $itemMaterial->id,
            'load_id' => $load->id,
        ]);

        Livewire::test(MaterialInvoiceTable::class)
            ->call('delete', $materialInvoice)
            ->assertRedirect(route('material-invoices.index'));

        $this->assertNotNull(session('error'));

        $this->assertDatabaseHas('material_invoice', [
            'id' => $materialInvoice->id,
        ]);
    }
}
