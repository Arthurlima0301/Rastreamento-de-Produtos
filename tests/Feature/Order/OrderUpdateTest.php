<?php

use App\Livewire\Orders\OrderForm;
use App\Models\Client;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class OrderUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_edit_page_can_be_rendered()
    {
        $client = Client::factory()->create([
            'name' => 'Empresa 1',
        ]);

        $order = Order::factory()->create([
            'order_code' => 'CUT-500',
            'client_id' => $client->id,
            'status' => 'ATIVA',
        ]);

        $response = $this->get(route('orders.edit', $order));

        $response->assertStatus(200);
        $response->assertSee('Editar Ordem de Corte');
        $response->assertSee('CUT-500');
        $response->assertSee('Empresa 1');
    }

    public function test_order_can_be_updated()
    {
        $client = Client::factory()->create([
            'name' => 'Empresa 1',
        ]);

        $newClient = Client::factory()->create([
            'name' => 'Empresa 2',
        ]);

        $order = Order::factory()->create([
            'order_code' => 'CUT-600',
            'client_id' => $client->id,
            'status' => 'ATIVA',
        ]);

        Livewire::test(OrderForm::class, ['orderId' => $order->id])
            ->set('order_code', 'CUT-601')
            ->set('client_id', $newClient->id)
            ->set('status', 'FINALIZADA')
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('orders.index'));

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'order_code' => 'CUT-601',
            'client_id' => $newClient->id,
            'status' => 'FINALIZADA',
        ]);
    }
}
