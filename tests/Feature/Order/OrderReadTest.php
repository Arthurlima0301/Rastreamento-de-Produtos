<?php

use App\Livewire\Orders\OrderTable;
use App\Models\Client;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class OrderReadTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_index_page_can_be_rendered()
    {
        $response = $this->get(route('orders.index'));

        $response->assertStatus(200);
        $response->assertSee('orders.order-table');
    }

    public function test_order_all_data_is_displayed()
    {
        $client = Client::factory()->create([
            'name' => 'Empresa 1',
        ]);

        Order::factory()->create([
            'order_code' => 'CUT-200',
            'client_id' => $client->id,
            'status' => 'ATIVA',
        ]);

        Order::factory()->create([
            'order_code' => 'CUT-201',
            'client_id' => $client->id,
            'status' => 'FINALIZADA',
        ]);

        $response = $this->get(route('orders.index'));

        $response->assertSee('CUT-200');
        $response->assertSee('CUT-201');
        $response->assertSee('Empresa 1');
        $response->assertSee('FINALIZADA');
    }

    public function test_order_search_functionality()
    {
        Order::factory()->create([
            'order_code' => 'CUT-300',
        ]);

        Order::factory()->create([
            'order_code' => 'CUT-400',
        ]);

        Livewire::test(OrderTable::class)
            ->set('search', 'CUT-3')
            ->assertSee('CUT-300')
            ->assertDontSee('CUT-400');
    }
}
