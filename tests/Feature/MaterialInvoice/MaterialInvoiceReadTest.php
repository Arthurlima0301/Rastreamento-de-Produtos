<?php

use App\Livewire\MaterialInvoices\MaterialInvoiceTable;
use App\Models\MaterialInvoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MaterialInvoiceReadTest extends TestCase
{
    use RefreshDatabase;

    public function test_material_invoice_index_page_can_be_rendered()
    {
        $response = $this->get(route('material-invoices.index'));

        $response->assertStatus(200);
        $response->assertSee('material-invoices.material-invoice-table');
    }

    public function test_material_invoice_all_data_is_displayed()
    {
        MaterialInvoice::factory()->create([
            'invoice_code' => '888100',
            'issued_at' => '2026-06-01',
        ]);

        MaterialInvoice::factory()->create([
            'invoice_code' => '888200',
            'issued_at' => '2026-06-02',
        ]);

        $response = $this->get(route('material-invoices.index'));

        $response->assertSee('888.100');
        $response->assertSee('888.200');
        $response->assertSee('01/06/2026');
    }

    public function test_material_invoice_search_functionality()
    {
        MaterialInvoice::factory()->create([
            'invoice_code' => '888100',
        ]);

        MaterialInvoice::factory()->create([
            'invoice_code' => '888200',
        ]);

        Livewire::test(MaterialInvoiceTable::class)
            ->set('search', '8881')
            ->assertSee('888.100')
            ->assertDontSee('888.200');
    }
}
