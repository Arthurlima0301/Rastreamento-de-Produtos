<?php

namespace Tests\Feature;

use App\Livewire\MaterialInvoices\MaterialInvoiceImportForm;
use App\Models\Material;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;

class ImportMaterialXMLTest extends TestCase
{
    use RefreshDatabase;

    public function test_import_valid_material_xml(): void
    {
        Material::factory()->create(['shipment_code' => '1001']);

        Livewire::test(MaterialInvoiceImportForm::class)
            ->set('xml_file', $this->xmlUpload('nota_fiscal_valida.xml'))
            ->call('import')
            ->assertRedirect(route('material-invoices.index'));

        $this->assertDatabaseHas('material_invoice', ['invoice_code' => '367935']);
        $this->assertDatabaseHas('item_material', ['number' => 1]);
    }

    public function test_do_not_import_invalid_material_xml(): void
    {
        Livewire::test(MaterialInvoiceImportForm::class)
            ->set('xml_file', $this->xmlUpload('nota_fiscal_invalida.xml'))
            ->call('import')
            ->assertHasErrors('xml_file');
    }

    public function test_do_not_import_duplicate_material_invoice(): void
    {
        Material::factory()->create(['shipment_code' => '1001']);

        Livewire::test(MaterialInvoiceImportForm::class)
            ->set('xml_file', $this->xmlUpload('nota_fiscal_valida.xml'))
            ->call('import');

        Livewire::test(MaterialInvoiceImportForm::class)
            ->set('xml_file', $this->xmlUpload('nota_fiscal_valida.xml'))
            ->call('import')
            ->assertHasErrors('xml_file');
    }

    public function test_do_not_import_material_xml_if_product_code_is_not_registered(): void
    {
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
