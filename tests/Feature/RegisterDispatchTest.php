<?php

namespace Tests\Feature;

use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterDispatchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test a dispatch registration.
     */
    public function test_register_dispatch()
    {
        $item = Item::factory()->create([
            'quantity' => 200,
        ]);

        $this->post('dispatches', [
            'items' => [
                0 => [
                    'id' => $item->id,
                    'quantity' => '10',
                ],
                1 => [
                    'id' => $item->id,
                    'quantity' => '10',
                ],
            ],
        ]);

        $this->assertDatabaseCount('dispatch_items', 2);
        $this->assertDatabaseHas('dispatch_items', [
            'item_id' => $item->id,
            'quantity' => '10',
        ]);
    }

    /**
     * Test register consume item with exact balance.
     */
    public function test_update_item_balance()
    {
        $item = Item::factory()->create([
            'quantity' => 100,
        ]);

        $this->post('dispatches', [
            'items' => [
                0 => [
                    'id' => $item->id,
                    'quantity' => '100',
                ],
            ],
        ]);

        $this->assertEquals(0, Item::withSum('dispatchItems', 'quantity')->find($item->id)->balance);
    }

    /**
     * Test register consume item with unsufficient balance.
     */
    public function test_do_not_allow_consuming_item_with_insufficient_balance()
    {
        $item = Item::factory()->create([
            'quantity' => 100,
        ]);

        $response = $this->post('dispatches', [
            'items' => [
                0 => [
                    'id' => $item->id,
                    'quantity' => '101',
                ],
            ],
        ]);

        $this->assertDatabaseCount('dispatches', 0);
        $this->assertDatabaseCount('dispatch_items', 0);
        $response->assertSessionHas('error');
    }

    /*
    * Test register consume item a decimal quantity.
    */
    public function test_allow_consuming_item_with_decimal_quantity()
    {
        $item = Item::factory()->create();

        $response = $this->post('dispatches', [
            'items' => [
                0 => [
                    'id' => $item->id,
                    'quantity' => '10.5',
                ],
            ],
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseCount('dispatch_items', 1);
        $this->assertDatabaseHas('dispatch_items', [
            'item_id' => $item->id,
            'quantity' => '10.5',
        ]);
    }


    /**
     * Test register with a nonexistent item.
     */
    public function test_do_not_allow_consuming_nonexistent_item()
    {
        $response = $this->post('dispatches', [
            'items' => [
                0 => [
                    'id' => 999,
                    'quantity' => '10',
                ],
            ],
        ]);

        $response->assertSessionHas('errors');
        $this->assertDatabaseCount('dispatches', 0);
        $this->assertDatabaseCount('dispatch_items', 0);
    }

    /**
     * Test register with a non-numeric quantity.
     */
    public function test_do_not_allow_consuming_item_with_non_numeric_quantity()
    {
        $item = Item::factory()->create();

        $response = $this->post('dispatches', [
            'items' => [
                0 => [
                    'id' => $item->id,
                    'quantity' => 'abc',
                ],
            ],
        ]);

        $response->assertSessionHas('errors');
        $this->assertDatabaseCount('dispatches', 0);
        $this->assertDatabaseCount('dispatch_items', 0);
    }
}
