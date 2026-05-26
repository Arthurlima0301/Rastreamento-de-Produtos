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
        // Create an item with a quantity of 200
        $item = SupplyItem::factory()->create([
            'quantity' => 200,
        ]);

        Livewire::test('dispatches.selected-items-list')
            ->set('selectedItems', [
                0 => [
                    'id' => $item->id,
                    'supply_name' => $item->supply_name,
                    'quantity' => '10',
                ],
            ])
            ->call('save')
            ->assertRedirect(route('dispatches.index'));

        $this->assertDatabaseCount('dispatch_items', 1);
        $this->assertDatabaseHas('dispatch_items', [
            'supply_item_id' => $item->id,
            'quantity' => '10',
        ]);
    }

    /**
     * Test register consume item with exact balance.
     */
    public function test_update_item_balance()
    {
        $item = SupplyItem::factory()->create([
            'quantity' => 100,
        ]);

        Livewire::test('dispatches.selected-items-list')
            ->set('selectedItems', [
                0 => [
                    'id' => $item->id,
                    'supply_name' => $item->supply_name,
                    'quantity' => '100',
                ],
            ])
            ->call('save')
            ->assertRedirect(route('dispatches.index'));

        $this->assertEquals(0.0, (float) SupplyItem::withBalance()->find($item->id)->balance);
    }

    /**
     * Test register consume item with unsufficient balance.
     */
    public function test_do_not_allow_consuming_item_with_insufficient_balance()
    {
        $item = SupplyItem::factory()->create([
            'quantity' => 100,
        ]);

        Livewire::test('dispatches.selected-items-list')
            ->set(
                'selectedItems',
                [
                    0 => [
                        'id' => $item->id,
                        'supply_name' => $item->supply_name,
                        'quantity' => '101',
                    ],
                ],
            )
            ->call('save')
            ->assertHasErrors('selectedItems');

        $this->assertDatabaseCount('dispatches', 0);
        $this->assertDatabaseCount('dispatch_items', 0);
    }

    /*
    * Test register consume item a decimal quantity.
    */
    public function test_allow_consuming_item_with_decimal_quantity()
    {
        $item = SupplyItem::factory()->create();

        Livewire::test('dispatches.selected-items-list')
            ->set(
                'selectedItems',
                [
                    0 => [
                        'id' => $item->id,
                        'supply_name' => $item->supply_name,
                        'quantity' => '10.5',
                    ],
                ],
            )
            ->call('save')
            ->assertRedirect(route('dispatches.index'));

        $this->assertDatabaseCount('dispatch_items', 1);
        $this->assertDatabaseHas('dispatch_items', [
            'supply_item_id' => $item->id,
            'quantity' => '10.5',
        ]);
    }

    /**
     * Test register with a nonexistent item.
     */
    public function test_do_not_allow_consuming_nonexistent_item()
    {
        Livewire::test('dispatches.selected-items-list')
            ->set(
                'selectedItems',
                [
                    0 => [
                        'id' => 999, // Nonexistent item ID
                        'supply_name' => 'nonexistent item',
                        'quantity' => '10',
                    ],
                ],
            )
            ->call('save')
            ->assertHasErrors('selectedItems');

        $this->assertDatabaseCount('dispatches', 0);
        $this->assertDatabaseCount('dispatch_items', 0);
    }

    /**
     * Test register with a non-numeric quantity.
     */
    public function test_do_not_allow_consuming_item_with_non_numeric_quantity()
    {
        $item = SupplyItem::factory()->create();

        Livewire::test('dispatches.selected-items-list')
            ->set(
                'selectedItems',
                [
                    0 => [
                        'id' => $item->id,
                        'supply_name' => $item->supply_name,
                        'quantity' => 'abc',
                    ],
                ],
            )
            ->call('save')
            ->assertHasErrors(['selectedItems.0.quantity']);

        $this->assertDatabaseCount('dispatches', 0);
        $this->assertDatabaseCount('dispatch_items', 0);
    }
}
