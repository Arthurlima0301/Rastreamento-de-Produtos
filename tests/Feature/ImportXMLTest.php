<?php

namespace Tests\Feature;

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

        $response = $this->post('invoices/import', [
            'xml_file' => new UploadedFile(
                base_path('tests/Fixtures/nota_fiscal_valida.xml'),
                'nota_fiscal_valida.xml',
                'text/xml',
                null,
                true
            ),
        ]);

        $response->assertRedirect(route('invoices.index'));
        $response->assertSessionHas('success');
    }

    /*
    * Test an invalid XML import
    */
    public function test_do_not_import_invalid_xml()
    {
        $response = $this->from(route('invoices.index'))->post('invoices/import', [
            'xml_file' => new UploadedFile(
                base_path('tests/Fixtures/nota_fiscal_invalida.xml'),
                'nota_fiscal_invalida.xml',
                'text/xml',
                null,
                true
            ),
        ]);

        $response->assertRedirect(route('invoices.index'));
        $response->assertSessionHasErrors('xml_file');
    }

    /**
     * Test that duplicate fiscal notes are not imported.
     */
    public function test_do_not_import_duplicate_invoice()
    {
        Supply::factory()->create(['supply_code' => '1001']);

        $this->post('invoices/import', [
            'xml_file' => new UploadedFile(
                base_path('tests/Fixtures/nota_fiscal_valida.xml'),
                'nota_fiscal_valida.xml',
                'text/xml',
                null,
                true
            ),
        ]);

        $response = $this->from(route('invoices.index'))->post('invoices/import', [
            'xml_file' => new UploadedFile(
                base_path('tests/Fixtures/nota_fiscal_valida.xml'),
                'nota_fiscal_valida.xml',
                'text/xml',
                null,
                true
            ),
        ]);

        $response->assertRedirect(route('invoices.index'));
        $response->assertSessionHasErrors('xml_file');
    }

    /**
     * Test that XML is not imported if the item product code is not registered.
     */
    public function test_do_not_import_xml_if_product_code_is_not_registered()
    {
        $response = $this->from(route('invoices.index'))->post('invoices/import', [
            'xml_file' => new UploadedFile(
                base_path('tests/Fixtures/nota_fiscal_valida.xml'),
                'nota_fiscal_valida.xml',
                'text/xml',
                null,
                true
            ),
        ]);

        $response->assertRedirect(route('invoices.index'));
        $response->assertSessionHasErrors('xml_file');
    }
}
