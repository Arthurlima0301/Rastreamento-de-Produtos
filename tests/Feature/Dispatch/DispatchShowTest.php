<?php

use App\Models\Dispatch;
use App\Models\DispatchItem;
use App\Models\Supply;
use App\Models\SupplyInvoice;
use App\Models\SupplyItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DispatchShowTest extends TestCase
{
    use RefreshDatabase;

    // Test that the dispatch show page can be rendered.
    public function test_dispatch_show_page_can_be_rendered()
    {
        $dispatch = Dispatch::factory()->create();

        $response = $this->get(route('dispatches.show', $dispatch));

        $response->assertStatus(200);
        $response->assertSee('Detalhes');
    }

    // Test that dispatch information and items are displayed.
    public function test_dispatch_items_and_information_are_displayed()
    {
        $dispatch = Dispatch::factory()->create([
            'invoice' => 'NF100',
            'dispatched_at' => '2026-06-01',
        ]);

        $supply = Supply::factory()->create([
            'supply_code' => 'SUP-100',
            'name' => 'Cola Hotmelt',
            'unit_of_measure' => 'kg',
        ]);

        $supplyInvoice = SupplyInvoice::factory()->create([
            'supply_invoice_code' => '999100',
        ]);

        $supplyItem = SupplyItem::factory()->create([
            'number' => 5,
            'supply_id' => $supply->id,
            'supply_invoice_id' => $supplyInvoice->id,
            'quantity' => 100,
        ]);

        DispatchItem::factory()->create([
            'dispatch_id' => $dispatch->id,
            'supply_item_id' => $supplyItem->id,
            'quantity' => 25,
        ]);

        $response = $this->get(route('dispatches.show', $dispatch));

        $response->assertSee('NF100');
        $response->assertSee('01/06/2026');
        $response->assertSee('25,00');
        $response->assertSee('SUP-100');
        $response->assertSee('Cola Hotmelt');
        $response->assertSee('999.100');
        $response->assertSee('(Item 5)');
    }
}
