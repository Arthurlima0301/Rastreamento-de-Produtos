<?php

namespace Tests\Feature;

use App\Livewire\Clients\ClientTable;
use App\Livewire\Dispatches\CreateDispatch;
use App\Livewire\Dispatches\DispatchTable;
use App\Livewire\Supplies\SupplyTable;
use App\Livewire\SupplyInvoices\SupplyInvoiceTable;
use App\Livewire\SupplyItems\SupplyItemTable;
use App\Models\Client;
use App\Models\Dispatch;
use App\Models\Supply;
use App\Models\SupplyInvoice;
use App\Models\SupplyItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_filter_clients_by_search_prefix(): void
    {
        Client::factory()->create([
            'name' => 'Cliente Alpha',
        ]);

        Client::factory()->create([
            'name' => 'Cliente Beta',
        ]);

        Livewire::test(ClientTable::class)
            ->set('search', 'Cliente A')
            ->assertSee('Cliente Alpha')
            ->assertDontSee('Cliente Beta');
    }

    public function test_filter_supplies_by_search_prefix(): void
    {
        Supply::factory()->create([
            'supply_code' => 'ABC123',
            'name' => 'Cimento',
            'unit_of_measure' => 'kg',
        ]);

        Supply::factory()->create([
            'supply_code' => 'XYZ123',
            'name' => 'Areia',
            'unit_of_measure' => 'm',
        ]);

        Livewire::test(SupplyTable::class)
            ->set('search', 'Cim')
            ->assertSee('ABC123')
            ->assertDontSee('XYZ123');
    }

    public function test_filter_items_by_search_prefix(): void
    {
        $matchedSupply = Supply::factory()->create([
            'supply_code' => 'SUP100',
            'name' => 'Brita',
        ]);

        $otherSupply = Supply::factory()->create([
            'supply_code' => 'SUP200',
            'name' => 'Cal',
        ]);

        SupplyItem::factory()->create([
            'number' => 10,
            'supply_id' => $matchedSupply->id,
        ]);

        SupplyItem::factory()->create([
            'number' => 20,
            'supply_id' => $otherSupply->id,
        ]);

        Livewire::test(SupplyItemTable::class)
            ->set('search', 'Bri')
            ->assertSee('Brita')
            ->assertDontSee('Cal');
    }

    public function test_filter_invoices_by_search_prefix(): void
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

    public function test_filter_invoices_by_formatted_numeric_code_prefix(): void
    {
        SupplyInvoice::factory()->create([
            'supply_invoice_code' => '1234',
        ]);

        SupplyInvoice::factory()->create([
            'supply_invoice_code' => '2234',
        ]);

        Livewire::test(SupplyInvoiceTable::class)
            ->set('search', '1.234')
            ->assertSee('1.234')
            ->assertDontSee('2.234');
    }

    public function test_filter_dispatches_by_search_prefix(): void
    {
        Dispatch::factory()->create([
            'invoice' => 'NF100',
        ]);

        Dispatch::factory()->create([
            'invoice' => 'NF200',
        ]);

        Livewire::test(DispatchTable::class)
            ->set('search', 'NF1')
            ->assertSee('NF100')
            ->assertDontSee('NF200');
    }

    public function test_filter_dispatch_creation_items_by_search_prefix(): void
    {
        $matchedSupply = Supply::factory()->create([
            'supply_code' => 'SUP100',
            'name' => 'Brita',
        ]);

        $otherSupply = Supply::factory()->create([
            'supply_code' => 'SUP200',
            'name' => 'Cal',
        ]);

        SupplyItem::factory()->create([
            'number' => 10,
            'supply_id' => $matchedSupply->id,
        ]);

        SupplyItem::factory()->create([
            'number' => 20,
            'supply_id' => $otherSupply->id,
        ]);

        Livewire::test(CreateDispatch::class)
            ->set('search', 'Bri')
            ->assertSee('Brita')
            ->assertDontSee('Cal');
    }
}
