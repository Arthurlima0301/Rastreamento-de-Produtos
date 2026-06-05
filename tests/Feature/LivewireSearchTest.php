<?php

namespace Tests\Feature;

use App\Livewire\Clients\ClientTable;
use App\Livewire\Dispatches\DispatchCreate;
use App\Livewire\Dispatches\DispatchTable;
use App\Livewire\ItemMaterials\ItemMaterialShow;
use App\Livewire\ItemMaterials\ItemMaterialTable;
use App\Livewire\MaterialInvoices\MaterialInvoiceTable;
use App\Livewire\Orders\OrderTable;
use App\Livewire\Supplies\SupplyTable;
use App\Livewire\SupplyInvoices\SupplyInvoiceTable;
use App\Livewire\SupplyItems\SupplyItemTable;
use App\Models\Client;
use App\Models\Dispatch;
use App\Models\ItemMaterial;
use App\Models\Material;
use App\Models\MaterialInvoice;
use App\Models\Order;
use App\Models\Roll;
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

    public function test_filter_supply_items_by_search_prefix(): void
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

    public function test_filter_supply_invoices_by_search_prefix(): void
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

    public function test_filter_supply_invoices_by_formatted_numeric_code_prefix(): void
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

    public function test_filter_orders_by_search_prefix(): void
    {
        Order::factory()->create([
            'order_code' => 'CUT100',
        ]);

        Order::factory()->create([
            'order_code' => 'CUT200',
        ]);

        Livewire::test(OrderTable::class)
            ->set('search', 'CUT1')
            ->assertSee('CUT100')
            ->assertDontSee('CUT200');
    }

    public function test_filter_material_invoices_by_search_prefix(): void
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

    public function test_filter_item_materials_by_search_prefix(): void
    {
        $matchedMaterial = Material::factory()->create([
            'paper' => 'Cartao',
        ]);

        $otherMaterial = Material::factory()->create([
            'paper' => 'Offset',
        ]);

        ItemMaterial::factory()->create([
            'number' => 10,
            'material_id' => $matchedMaterial->id,
        ]);

        ItemMaterial::factory()->create([
            'number' => 20,
            'material_id' => $otherMaterial->id,
        ]);

        Livewire::test(ItemMaterialTable::class)
            ->set('search', 'Car')
            ->assertSee('Cartao')
            ->assertDontSee('Offset');
    }

    public function test_filter_dispatch_creation_supply_items_by_search_prefix(): void
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

        Livewire::test(DispatchCreate::class)
            ->set('search', 'Bri')
            ->assertSee('Brita')
            ->assertDontSee('Cal');
    }

    public function test_filter_rolls_by_search_prefix(): void
    {
        $itemMaterial = ItemMaterial::factory()->create();

        Roll::factory()->create([
            'label' => '123456789-0001',
            'item_material_id' => $itemMaterial->id,
        ]);

        Roll::factory()->create([
            'label' => '123456789-0002',
            'item_material_id' => $itemMaterial->id,
        ]);

        Livewire::test(ItemMaterialShow::class, ['itemMaterial' => $itemMaterial])
            ->set('search', '123456789-0001')
            ->assertSee('123456789-0001')
            ->assertDontSee('123456789-0002');
    }
}
