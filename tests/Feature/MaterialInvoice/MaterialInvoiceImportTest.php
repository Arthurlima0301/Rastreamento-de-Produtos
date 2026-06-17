<?php

use App\Livewire\MaterialInvoices\MaterialInvoiceImportForm;
use App\Models\Material;
use App\Models\MaterialInvoice;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;

class MaterialInvoiceImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_material_invoice_import_page_can_be_rendered()
    {
        $response = $this->get(route('material-invoices.index'));

        $response->assertStatus(200);
        $response->assertSee('Importar XML');
    }

    public function test_material_invoice_can_be_imported_from_xml_fixture()
    {
        $order = Order::factory()->create([
            'status' => 'ATIVA',
        ]);

        $material = Material::factory()->create([
            'order_id' => $order->id,
            'shipment_code' => 1001,
            'paper' => 'Kraft',
        ]);

        Livewire::test(MaterialInvoiceImportForm::class)
            ->set('xml_file', $this->xmlUpload('nota_fiscal_valida.xml'))
            ->call('import')
            ->assertHasNoErrors()
            ->assertRedirect(route('material-invoices.index'));

        $materialInvoice = MaterialInvoice::query()->firstOrFail();

        $this->assertEquals('367935', $materialInvoice->invoice_code);
        $this->assertSame('17/12/2025', $materialInvoice->formatted_issued_at);

        $this->assertDatabaseHas('item_material', [
            'number' => 1,
            'material_invoice_id' => $materialInvoice->id,
            'material_id' => $material->id,
            'total_weight' => 24,
        ]);
    }

    public function test_material_invoice_rule_rejects_invalid_xml()
    {
        Livewire::test(MaterialInvoiceImportForm::class)
            ->set('xml_file', $this->xmlUpload('nota_fiscal_invalida.xml'))
            ->call('import')
            ->assertHasErrors('xml_file');
    }

    public function test_material_invoice_rule_rejects_duplicate_invoice()
    {
        $order = Order::factory()->create([
            'status' => 'ATIVA',
        ]);

        Material::factory()->create([
            'order_id' => $order->id,
            'shipment_code' => 1001,
        ]);

        Livewire::test(MaterialInvoiceImportForm::class)
            ->set('xml_file', $this->xmlUpload('nota_fiscal_valida.xml'))
            ->call('import');

        Livewire::test(MaterialInvoiceImportForm::class)
            ->set('xml_file', $this->xmlUpload('nota_fiscal_valida.xml'))
            ->call('import')
            ->assertHasErrors('xml_file');
    }

    public function test_material_invoice_rule_rejects_unregistered_material_code()
    {
        Order::factory()->create([
            'status' => 'ATIVA',
        ]);

        Livewire::test(MaterialInvoiceImportForm::class)
            ->set('xml_file', $this->xmlUpload('nota_fiscal_valida.xml'))
            ->call('import')
            ->assertHasErrors('xml_file');
    }

    public function test_material_invoice_rule_rejects_when_there_is_no_active_order()
    {
        $order = Order::factory()->create([
            'status' => 'FINALIZADA',
        ]);

        Material::factory()->create([
            'order_id' => $order->id,
            'shipment_code' => 1001,
        ]);

        Livewire::test(MaterialInvoiceImportForm::class)
            ->set('xml_file', $this->xmlUpload('nota_fiscal_valida.xml'))
            ->call('import')
            ->assertHasErrors('xml_file');
    }

    private function xmlUpload(string $filename): UploadedFile
    {
        return UploadedFile::fake()->createWithContent(
            $filename,
            file_get_contents(base_path("tests/Fixtures/{$filename}"))
        );
    }
}
