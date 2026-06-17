<?php

use App\Livewire\SupplyInvoices\SupplyInvoiceTable;
use App\Models\SupplyInvoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SupplyInvoiceReadTest extends TestCase
{
    use RefreshDatabase;

    public function test_supply_invoice_index_page_can_be_rendered()
    {
        $response = $this->get(route('supply-invoices.index'));

        $response->assertStatus(200);
        $response->assertSee('supply-invoices.supply-invoice-table');
    }

    public function test_supply_invoice_all_data_is_displayed()
    {
        SupplyInvoice::factory()->create([
            'supply_invoice_code' => '999100',
            'issued_at' => '2026-06-01 00:00:00',
        ]);

        SupplyInvoice::factory()->create([
            'supply_invoice_code' => '999200',
            'issued_at' => '2026-06-02 00:00:00',
        ]);

        $response = $this->get(route('supply-invoices.index'));

        $response->assertSee('999.100');
        $response->assertSee('999.200');
        $response->assertSee('01/06/2026');
    }

    public function test_supply_invoice_search_functionality()
    {
        SupplyInvoice::factory()->create([
            'supply_invoice_code' => '999100',
        ]);

        SupplyInvoice::factory()->create([
            'supply_invoice_code' => '999200',
        ]);

        Livewire::test(SupplyInvoiceTable::class)
            ->set('search', '9991')
            ->assertSee('999.100')
            ->assertDontSee('999.200');
    }
}
