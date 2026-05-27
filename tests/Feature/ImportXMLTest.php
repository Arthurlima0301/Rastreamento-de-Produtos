<?php

namespace Tests\Feature;

use App\Livewire\Invoices\InvoiceImportForm;
use App\Models\Supply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
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

        Livewire::test(InvoiceImportForm::class)
            ->set('xml_file', $this->xmlUpload('nota_fiscal_valida.xml'))
            ->call('import')
            ->assertRedirect(route('invoices.index'));

        $this->assertDatabaseHas('invoices', ['invoice_code' => '367935']);
    }

    /*
    * Test an invalid XML import
    */
    public function test_do_not_import_invalid_xml()
    {
        Livewire::test(InvoiceImportForm::class)
            ->set('xml_file', $this->xmlUpload('nota_fiscal_invalida.xml'))
            ->call('import')
            ->assertHasErrors('xml_file');
    }

    /**
     * Test that duplicate fiscal notes are not imported.
     */
    public function test_do_not_import_duplicate_invoice()
    {
        Supply::factory()->create(['supply_code' => '1001']);

        Livewire::test(InvoiceImportForm::class)
            ->set('xml_file', $this->xmlUpload('nota_fiscal_valida.xml'))
            ->call('import');

        Livewire::test(InvoiceImportForm::class)
            ->set('xml_file', $this->xmlUpload('nota_fiscal_valida.xml'))
            ->call('import')
            ->assertHasErrors('xml_file');
    }

    /**
     * Test that XML is not imported if the item product code is not registered.
     */
    public function test_do_not_import_xml_if_product_code_is_not_registered()
    {
        Livewire::test(InvoiceImportForm::class)
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
