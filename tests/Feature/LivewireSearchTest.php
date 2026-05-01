<?php

namespace Tests\Feature;

use App\Livewire\Dispatches\DispatchTable;
use App\Livewire\Invoices\InvoiceTable;
use App\Livewire\Items\ItemTable;
use App\Livewire\Supplies\SupplyTable;
use App\Models\Dispatch;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\Supply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireSearchTest extends TestCase
{
    use RefreshDatabase;

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

        Item::factory()->create([
            'number' => 10,
            'supply_id' => $matchedSupply->id,
        ]);

        Item::factory()->create([
            'number' => 20,
            'supply_id' => $otherSupply->id,
        ]);

        Livewire::test(ItemTable::class)
            ->set('search', 'Bri')
            ->assertSee('Brita')
            ->assertDontSee('Cal');
    }

    public function test_filter_invoices_by_search_prefix(): void
    {
        Invoice::factory()->create([
            'invoice_code' => 'NF100',
        ]);

        Invoice::factory()->create([
            'invoice_code' => 'NF200',
        ]);

        Livewire::test(InvoiceTable::class)
            ->set('search', 'NF1')
            ->assertSee('NF100')
            ->assertDontSee('NF200');
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
}
