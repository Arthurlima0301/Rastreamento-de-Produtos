<?php

use App\Livewire\SupplyInvoices\SupplyInvoiceTable;
use App\Models\SupplyInvoice;
use App\Models\SupplyItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SupplyItemDeleteTest extends TestCase
{
    use RefreshDatabase;

    // Test that supply items are deleted when their invoice is deleted.
    public function test_supply_item_is_deleted_when_invoice_is_deleted()
    {
        $supplyInvoice = SupplyInvoice::factory()->create([
            'supply_invoice_code' => '777100',
        ]);

        $supplyItem = SupplyItem::factory()->create([
            'supply_invoice_id' => $supplyInvoice->id,
        ]);

        Livewire::test(SupplyInvoiceTable::class)
            ->call('delete', $supplyInvoice)
            ->assertRedirect(route('supply-invoices.index'));

        $this->assertDatabaseMissing('supply_items', [
            'id' => $supplyItem->id,
        ]);
    }
}
