<?php

use App\Livewire\Orders\OrderForm;
use App\Models\Client;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class OrderCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_create_page_can_be_rendered()
    {
        $response = $this->get(route('orders.create'));

        $response->assertStatus(200);
        $response->assertSee('Criar Ordem de Corte');
    }

    public function test_order_can_be_created()
    {
        $client = Client::factory()->create([
            'name' => 'Empresa 1',
        ]);

        Livewire::test(OrderForm::class)
            ->set('order_code', 'CUT-100')
            ->set('client_id', $client->id)
            ->set('status', 'ATIVA')
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('orders.index'));

        $this->assertDatabaseHas('orders', [
            'order_code' => 'CUT-100',
            'client_id' => $client->id,
            'status' => 'ATIVA',
        ]);
    }

    public function test_order_is_associated_with_client()
    {
        $client = Client::factory()->create([
            'name' => 'Empresa 1',
        ]);

        $order = Order::factory()->create([
            'client_id' => $client->id,
        ]);

        $this->assertTrue($order->client->is($client));
    }
}
