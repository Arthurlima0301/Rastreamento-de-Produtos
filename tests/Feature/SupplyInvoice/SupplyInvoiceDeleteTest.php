<?php

use App\Livewire\SupplyInvoices\SupplyInvoiceTable;
use App\Models\DispatchItem;
use App\Models\SupplyInvoice;
use App\Models\SupplyItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SupplyInvoiceDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_supply_invoice_index_page_can_be_rendered()
    {
        $response = $this->get(route('supply-invoices.index'));

        $response->assertStatus(200);
        $response->assertSee('supply-invoices.supply-invoice-table');
    }

    public function test_supply_invoice_can_be_deleted_with_its_items()
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

        $this->assertDatabaseMissing('supply_invoices', [
            'id' => $supplyInvoice->id,
        ]);

        $this->assertDatabaseMissing('supply_items', [
            'id' => $supplyItem->id,
        ]);
    }

    public function test_supply_invoice_cannot_be_deleted_when_supply_item_has_dispatch()
    {
        $supplyInvoice = SupplyInvoice::factory()->create([
            'supply_invoice_code' => '777300',
        ]);

        $supplyItem = SupplyItem::factory()->create([
            'supply_invoice_id' => $supplyInvoice->id,
        ]);

        DispatchItem::factory()->create([
            'supply_item_id' => $supplyItem->id,
        ]);

        Livewire::test(SupplyInvoiceTable::class)
            ->call('delete', $supplyInvoice)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('supply_invoices', [
            'id' => $supplyInvoice->id,
        ]);
    }
}
