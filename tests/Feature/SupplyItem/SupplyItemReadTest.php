<?php

use App\Livewire\SupplyItems\SupplyItemTable;
use App\Models\Client;
use App\Models\Supply;
use App\Models\SupplyInvoice;
use App\Models\SupplyItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SupplyItemReadTest extends TestCase
{
    use RefreshDatabase;

    // Test that the supply item index page and table component can be rendered.
    public function test_supply_item_index_page_can_be_rendered()
    {
        $response = $this->get(route('supply-items.index'));

        $response->assertStatus(200);
        $response->assertSee('Itens de Insumo');
        $response->assertSee('supply-items.supply-item-table');
    }

    // Test that supply item data is listed on the index page.
    public function test_supply_item_all_data_is_displayed()
    {
        $client = Client::factory()->create([
            'name' => 'Empresa 1',
        ]);

        $supply = Supply::factory()->create([
            'supply_code' => 'SUP-100',
            'name' => 'Cola Hotmelt',
            'unit_of_measure' => 'kg',
            'client_id' => $client->id,
        ]);

        $supplyInvoice = SupplyInvoice::factory()->create([
            'supply_invoice_code' => '999100',
            'issued_at' => '2026-06-01',
        ]);

        SupplyItem::factory()->create([
            'number' => 5,
            'supply_id' => $supply->id,
            'supply_invoice_id' => $supplyInvoice->id,
            'quantity' => 24,
        ]);

        $response = $this->get(route('supply-items.index'));

        $response->assertSee('SUP-100');
        $response->assertSee('Cola Hotmelt');
        $response->assertSee('Empresa 1');
        $response->assertSee('999.100');
        $response->assertSee('24,00');
    }

    // Test search functionality on the supply item table.
    public function test_supply_item_search_functionality()
    {
        $matchedSupply = Supply::factory()->create([
            'name' => 'Cola Hotmelt',
        ]);

        $otherSupply = Supply::factory()->create([
            'name' => 'Fita Kraft',
        ]);

        SupplyItem::factory()->create([
            'supply_id' => $matchedSupply->id,
        ]);

        SupplyItem::factory()->create([
            'supply_id' => $otherSupply->id,
        ]);

        Livewire::test(SupplyItemTable::class)
            ->set('search', 'Cola')
            ->assertSee('Cola Hotmelt')
            ->assertDontSee('Fita Kraft');
    }
}
