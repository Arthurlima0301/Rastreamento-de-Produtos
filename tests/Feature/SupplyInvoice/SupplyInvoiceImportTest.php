<?php

use App\Livewire\SupplyInvoices\SupplyInvoiceImportForm;
use App\Models\Supply;
use App\Models\SupplyInvoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;

class SupplyInvoiceImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_supply_invoice_import_page_can_be_rendered()
    {
        $response = $this->get(route('supply-invoices.index'));

        $response->assertStatus(200);
        $response->assertSee('Importar XML');
    }

    public function test_supply_invoice_can_be_imported_from_xml_fixture()
    {
        $supply = Supply::factory()->create([
            'supply_code' => '1001',
            'name' => 'Pallete de Madeira',
            'unit_of_measure' => 'PC',
        ]);

        Livewire::test(SupplyInvoiceImportForm::class)
            ->set('xml_file', $this->xmlUpload('nota_fiscal_valida.xml'))
            ->call('import')
            ->assertHasNoErrors()
            ->assertRedirect(route('supply-invoices.index'));

        $supplyInvoice = SupplyInvoice::query()->firstOrFail();

        $this->assertEquals('367935', $supplyInvoice->supply_invoice_code);
        $this->assertSame('17/12/2025', $supplyInvoice->formatted_issued_at);

        $this->assertDatabaseHas('supply_items', [
            'number' => 1,
            'supply_invoice_id' => $supplyInvoice->id,
            'supply_id' => $supply->id,
            'quantity' => 24,
        ]);
    }

    public function test_supply_invoice_rule_rejects_invalid_xml()
    {
        Livewire::test(SupplyInvoiceImportForm::class)
            ->set('xml_file', $this->xmlUpload('nota_fiscal_invalida.xml'))
            ->call('import')
            ->assertHasErrors('xml_file');
    }

    public function test_supply_invoice_rule_rejects_duplicate_invoice()
    {
        Supply::factory()->create([
            'supply_code' => '1001',
        ]);

        Livewire::test(SupplyInvoiceImportForm::class)
            ->set('xml_file', $this->xmlUpload('nota_fiscal_valida.xml'))
            ->call('import');

        Livewire::test(SupplyInvoiceImportForm::class)
            ->set('xml_file', $this->xmlUpload('nota_fiscal_valida.xml'))
            ->call('import')
            ->assertHasErrors('xml_file');
    }

    public function test_supply_invoice_rule_rejects_unregistered_supply_code()
    {
        Livewire::test(SupplyInvoiceImportForm::class)
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
