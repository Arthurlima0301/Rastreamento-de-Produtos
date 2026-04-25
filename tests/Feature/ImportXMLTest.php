<?php

namespace Tests\Feature;

use App\Models\Supply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImportXMLTest extends TestCase
{
    use RefreshDatabase;

    /*
    * Test a valid XML import
    */
    public function test_import_valid_xml()
    {
        Supply::create(['supply_code' => '1001', 'name' => 'Produto Genérico 1', 'unit_of_measure' => 'UN']);
        Supply::create(['supply_code' => '1002', 'name' => 'Produto Genérico 2', 'unit_of_measure' => 'UN']);

        $response = $this->post('invoices/import', [
            'xml_file' => new \Illuminate\Http\UploadedFile(
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
        $response = $this->post('invoices/import', [
            'xml_file' => new \Illuminate\Http\UploadedFile(
                base_path('tests/Fixtures/nota_fiscal_invalida.xml'),
                'nota_fiscal_invalida.xml',
                'text/xml',
                null,
                true
            ),
        ]);

        $response->assertRedirect(route('invoices.index'));
        $response->assertSessionHas('error');
    }

    /**
     * Test that duplicate fiscal notes are not imported.
     */
    public function test_do_not_import_duplicate_invoice()
    {
        $this->post('invoices/import', [
            'xml_file' => new \Illuminate\Http\UploadedFile(
                base_path('tests/Fixtures/nota_fiscal_valida.xml'),
                'nota_fiscal_valida.xml',
                'text/xml',
                null,
                true
            ),
        ]);

        $response = $this->post('invoices/import', [
            'xml_file' => new \Illuminate\Http\UploadedFile(
                base_path('tests/Fixtures/nota_fiscal_valida.xml'),
                'nota_fiscal_valida.xml',
                'text/xml',
                null,
                true
            ),
        ]);

        $response->assertRedirect(route('invoices.index'));
        $response->assertSessionHas('error');
    }

    /**
     * Test that XML is not imported if the item product code is not registered.
     */
    public function test_do_not_import_xml_if_product_code_is_not_registered()
    {
        $response = $this->post('invoices/import', [
            'xml_file' => new \Illuminate\Http\UploadedFile(
                base_path('tests/Fixtures/nota_fiscal_valida.xml'),
                'nota_fiscal_valida.xml',
                'text/xml',
                null,
                true
            ),
        ]);
        $response->assertRedirect(route('invoices.index'));
        $response->assertSessionHas('error');
    }
}
