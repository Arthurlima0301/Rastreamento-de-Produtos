<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Invoice;
use App\Models\Supply;
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
        Supply::create([
            'supply_code' => '1',
            'name' => 'Produto 1',
            'unit_of_measure' => 'un',
        ]);

        Invoice::create([
            'invoice_code' => '445551',
            'issued_at' => '2024-01-01',
        ]);

        Item::create([
            'number' => '1',
            'invoice_id' => '1',
            'supply_id' => '1',
            'quantity' => '200',
        ]);

        $this->post('dispatches', [
            'items' => [
                0 => [
                    'id' => '1',
                    'quantity' => '10',
                ],
                1 => [
                    'id' => '1',
                    'quantity' => '10',
                ],
            ],
        ]);

        $this->assertDatabaseHas('dispatch_items', [
            'id' => '1',
            'quantity' => '10',
        ]);

        $this->assertDatabaseHas('dispatch_items', [
            'id' => '2',
            'quantity' => '10',
        ]);
    }

    /**
     * Test register consume item with exact balance.
     */
    public function test_update_item_balance()
    {
        Supply::create([
            'supply_code' => '1',
            'name' => 'Produto 1',
            'unit_of_measure' => 'un',
        ]);

        Invoice::create([
            'invoice_code' => '445551',
            'issued_at' => '2024-01-01',
        ]);

        Item::create([
            'number' => '1',
            'invoice_id' => '1',
            'supply_id' => '1',
            'quantity' => '100',
        ]);

        $this->post('dispatches', [
            'items' => [
                0 => [
                    'id' => '1',
                    'quantity' => '100',
                ],
            ],
        ]);

        $this->assertEquals(0, Item::withSum('dispatchItems', 'quantity')->find(1)->balance);
    }

    /**
     * Test register consume item with unsufficient balance.
     */
    public function test_do_not_allow_consuming_item_with_insufficient_balance()
    {
        Supply::create([
            'supply_code' => '1',
            'name' => 'Produto 1',
            'unit_of_measure' => 'un',
        ]);

        Invoice::create([
            'invoice_code' => '445551',
            'issued_at' => '2024-01-01',
        ]);

        Item::create([
            'number' => '1',
            'invoice_id' => '1',
            'supply_id' => '1',
            'quantity' => '100',
        ]);

        $response = $this->post('dispatches', [
            'items' => [
                0 => [
                    'id' => '1',
                    'quantity' => '101',
                ],
            ],
        ]);

        $this->assertDatabaseMissing('dispatches', [
            'id' => '1',
        ]);

        $this->assertDatabaseMissing('dispatch_items', [
            'id' => '1',
        ]);

        $response->assertSessionHas('error');
    }
}
