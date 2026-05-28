<?php

namespace Tests\Feature;

use App\Models\SupplyItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class RegisterDispatchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test a dispatch registration.
     */
    public function test_register_dispatch()
    {
        $supplyItem = SupplyItem::factory()->create([
            'quantity' => 200,
        ]);

        Livewire::test('dispatches.selected-supply-items-list')
            ->set('selectedSupplyItems', [
                0 => [
                    'id' => $supplyItem->id,
                    'supply_name' => $supplyItem->supply_name,
                    'quantity' => '10',
                ],
            ])
            ->call('save')
            ->assertRedirect(route('dispatches.index'));


        $this->assertDatabaseCount('dispatch_items', 1);
        $this->assertDatabaseHas('dispatch_items', [
            'supply_item_id' => $supplyItem->id,
            'quantity' => '10',
        ]);
    }

    /**
     * Test register consume supply item with exact balance.
     */
    public function test_update_item_balance()
    {
        $supplyItem = SupplyItem::factory()->create([
            'quantity' => 100,
        ]);

        Livewire::test('dispatches.selected-supply-items-list')
            ->set('selectedSupplyItems', [
                0 => [
                    'id' => $supplyItem->id,
                    'supply_name' => $supplyItem->supply_name,
                    'quantity' => '100',
                ],
            ])
            ->call('save')
            ->assertRedirect(route('dispatches.index'));

        $this->assertEquals(0.0, (float) SupplyItem::withBalance()->find($supplyItem->id)->balance);
    }

    /**
     * Test register consume supply item with unsufficient balance.
     */
    public function test_do_not_allow_consuming_item_with_insufficient_balance()
    {
        $supplyItem = SupplyItem::factory()->create([
            'quantity' => 100,
        ]);

        Livewire::test('dispatches.selected-supply-items-list')
            ->set(
                'selectedSupplyItems',
                [
                    0 => [
                        'id' => $supplyItem->id,
                        'supply_name' => $supplyItem->supply_name,
                        'quantity' => '101',
                    ],
                ],
            )
            ->call('save')
            ->assertHasErrors('selectedSupplyItems');

        $this->assertDatabaseCount('dispatches', 0);
        $this->assertDatabaseCount('dispatch_items', 0);
    }

    /*
    * Test register consume supply item a decimal quantity.
    */
    public function test_allow_consuming_item_with_decimal_quantity()
    {
        $supplyItem = SupplyItem::factory()->create();

        Livewire::test('dispatches.selected-supply-items-list')
            ->set(
                'selectedSupplyItems',
                [
                    0 => [
                        'id' => $supplyItem->id,
                        'supply_name' => $supplyItem->supply_name,
                        'quantity' => '10.5',
                    ],
                ],
            )
            ->call('save')
            ->assertRedirect(route('dispatches.index'));

        $this->assertDatabaseCount('dispatch_items', 1);
        $this->assertDatabaseHas('dispatch_items', [
            'supply_item_id' => $supplyItem->id,
            'quantity' => '10.5',
        ]);
    }


    /**
     * Test register with a nonexistent supply item.
     */
    public function test_do_not_allow_consuming_nonexistent_item()
    {
        Livewire::test('dispatches.selected-supply-items-list')
            ->set(
                'selectedSupplyItems',
                [
                    0 => [
                        'id' => 999, // Nonexistent supply item ID
                        'supply_name' => "nonexistent supply item",
                        'quantity' => '10',
                    ],
                ],
            )
            ->call('save')
            ->assertHasErrors('selectedSupplyItems');

        $this->assertDatabaseCount('dispatches', 0);
        $this->assertDatabaseCount('dispatch_items', 0);
    }

    /**
     * Test register supply item with a non-numeric quantity.
     */
    public function test_do_not_allow_consuming_item_with_non_numeric_quantity()
    {
        $supplyItem = SupplyItem::factory()->create();

        Livewire::test('dispatches.selected-supply-items-list')
            ->set(
                'selectedSupplyItems',
                [
                    0 => [
                        'id' => $supplyItem->id,
                        'supply_name' => $supplyItem->supply_name,
                        'quantity' => 'abc',
                    ],
                ],
            )
            ->call('save')
            ->assertHasErrors(['selectedSupplyItems.0.quantity']);

        $this->assertDatabaseCount('dispatches', 0);
        $this->assertDatabaseCount('dispatch_items', 0);
    }
}
