<?php

namespace Tests\Feature;

use App\Models\Material;
use App\Models\Order;
use App\Models\Supply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ImportXMLTest extends TestCase
{
    use RefreshDatabase;

    /*
    * Test a valid XML import
    */
    public function test_import_valid_xml()
    {
        Supply::factory()->create(['supply_code' => '1001']);

        $response = $this->post('supply-invoices/import', [
            'xml_file' => new UploadedFile(
                base_path('tests/Fixtures/nota_fiscal_valida.xml'),
                'nota_fiscal_valida.xml',
                'text/xml',
                null,
                true
            ),
        ]);

        $response->assertRedirect(route('supply-invoices.index'));
        $response->assertSessionHas('success');
    }

    /*
    * Test an invalid XML import
    */
    public function test_do_not_import_invalid_xml()
    {
        $response = $this->from(route('supply-invoices.index'))->post('supply-invoices/import', [
            'xml_file' => new UploadedFile(
                base_path('tests/Fixtures/nota_fiscal_invalida.xml'),
                'nota_fiscal_invalida.xml',
                'text/xml',
                null,
                true
            ),
        ]);

        $response->assertRedirect(route('supply-invoices.index'));
        $response->assertSessionHasErrors('xml_file');
    }

    /**
     * Test that duplicate fiscal notes are not imported.
     */
    public function test_do_not_import_duplicate_invoice()
    {
        Supply::factory()->create(['supply_code' => '1001']);

        $this->post('supply-invoices/import', [
            'xml_file' => new UploadedFile(
                base_path('tests/Fixtures/nota_fiscal_valida.xml'),
                'nota_fiscal_valida.xml',
                'text/xml',
                null,
                true
            ),
        ]);

        $response = $this->from(route('supply-invoices.index'))->post('supply-invoices/import', [
            'xml_file' => new UploadedFile(
                base_path('tests/Fixtures/nota_fiscal_valida.xml'),
                'nota_fiscal_valida.xml',
                'text/xml',
                null,
                true
            ),
        ]);

        $response->assertRedirect(route('supply-invoices.index'));
        $response->assertSessionHasErrors('xml_file');
    }

    /**
     * Test that XML is not imported if the item product code is not registered.
     */
    public function test_do_not_import_xml_if_product_code_is_not_registered()
    {
        $response = $this->from(route('supply-invoices.index'))->post('supply-invoices/import', [
            'xml_file' => new UploadedFile(
                base_path('tests/Fixtures/nota_fiscal_valida.xml'),
                'nota_fiscal_valida.xml',
                'text/xml',
                null,
                true
            ),
        ]);

        $response->assertRedirect(route('supply-invoices.index'));
        $response->assertSessionHasErrors('xml_file');
    }

    /*
    * Test a valid material XML import
    */
    public function test_import_valid_material_xml()
    {
        $order = Order::factory()->create();
        Material::factory()->create([
            'order_id' => $order->id,
            'shipping_code' => 1001,
            'net_weight_p' => 432.00,
        ]);

        $response = $this->post('material-invoices/import', [
            'xml_file' => new UploadedFile(
                base_path('tests/Fixtures/nota_fiscal_valida.xml'),
                'nota_fiscal_valida.xml',
                'text/xml',
                null,
                true
            ),
        ]);

        $response->assertRedirect(route('material-invoices.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('material_invoices', [
            'material_invoice_code' => '367935',
        ]);
        $this->assertDatabaseHas('material_items', [
            'roll_quantity' => 24.00,
            'weight' => 432.00,
        ]);
    }

    /**
     * Test that duplicate material fiscal notes are not imported.
     */
    public function test_do_not_import_duplicate_material_invoice()
    {
        $order = Order::factory()->create();
        Material::factory()->create([
            'order_id' => $order->id,
            'shipping_code' => 1001,
        ]);

        $this->post('material-invoices/import', [
            'xml_file' => new UploadedFile(
                base_path('tests/Fixtures/nota_fiscal_valida.xml'),
                'nota_fiscal_valida.xml',
                'text/xml',
                null,
                true
            ),
        ]);

        $response = $this->from(route('material-invoices.index'))->post('material-invoices/import', [
            'xml_file' => new UploadedFile(
                base_path('tests/Fixtures/nota_fiscal_valida.xml'),
                'nota_fiscal_valida.xml',
                'text/xml',
                null,
                true
            ),
        ]);

        $response->assertRedirect(route('material-invoices.index'));
        $response->assertSessionHasErrors('xml_file');
    }

    /**
     * Test that material XML is not imported if the item product code is not registered.
     */
    public function test_do_not_import_material_xml_if_product_code_is_not_registered()
    {
        $response = $this->from(route('material-invoices.index'))->post('material-invoices/import', [
            'xml_file' => new UploadedFile(
                base_path('tests/Fixtures/nota_fiscal_valida.xml'),
                'nota_fiscal_valida.xml',
                'text/xml',
                null,
                true
            ),
        ]);

        $response->assertRedirect(route('material-invoices.index'));
        $response->assertSessionHasErrors('xml_file');
    }
}
