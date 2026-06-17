<?php

use App\Models\Supply;
use App\Models\SupplyInvoice;
use App\Services\SupplyInvoices\ExtractSupplyItems;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupplyItemCreateTest extends TestCase
{
    use RefreshDatabase;

    // Test that supply items are extracted from the invoice XML.
    public function test_supply_item_is_extracted_from_invoice_xml()
    {
        $supply = Supply::factory()->create([
            'supply_code' => '1001',
            'name' => 'Pallete de Madeira',
        ]);

        $supplyInvoice = SupplyInvoice::factory()->create();

        (new ExtractSupplyItems)->extract($this->xmlFixture(), $supplyInvoice->id);

        $this->assertDatabaseHas('supply_items', [
            'number' => 1,
            'supply_invoice_id' => $supplyInvoice->id,
            'supply_id' => $supply->id,
            'quantity' => 24,
        ]);
    }

    private function xmlFixture(): SimpleXMLElement
    {
        return simplexml_load_file(base_path('tests/Fixtures/nota_fiscal_valida.xml'));
    }
}
