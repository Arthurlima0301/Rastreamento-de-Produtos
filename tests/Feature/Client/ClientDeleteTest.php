<?php

use App\Livewire\Clients\ClientTable;
use App\Models\Client;
use App\Models\Order;
use App\Models\Supply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;

class ClientDeleteTest extends TestCase
{
    use RefreshDatabase;

    // Test that the client index page can be rendered
    public function test_client_index_page_can_be_rendered()
    {
        $response = $this->get(route('clients.index'));
        $response->assertStatus(200);
        $response->assertSee('clients.client-table');
    }

    // Test that a client can be deleted successfully
    public function test_client_can_be_deleted()
    {
        $client1 = Client::factory()->create([
            'name' => 'Empresa 1'
        ]);

        Client::factory()->create([
            'name' => 'Empresa 2'
        ]);

        Livewire::test(ClientTable::class)
            ->call('destroy', $client1)
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('clients', [
            'name' => 'Empresa 1'
        ]);

        $this->assertDatabaseHas('clients', [
            'name' => 'Empresa 2'
        ]);
    }

    // Test that a client cannot be deleted when it has an order
    public function test_cant_delete_client_with_orders()
    {
        $client1 = Client::factory()->create([
            'name' => 'Empresa 1'
        ]);

        Order::factory()->create([
            'client_id' => $client1->id
        ]);

        Livewire::test(ClientTable::class)
            ->call('destroy', $client1)
            ->assertRedirect(route('clients.index'));

        $this->assertEquals(
            'Não é possível deletar um cliente que possui insumos ou ordens associadas.',
            session('error')
        );

        $this->assertDatabaseHas('clients', [
            'name' => 'Empresa 1'
        ]);
    }

    // Test that a client cannot be deleted when it has a supply
    public function test_cant_delete_client_with_supplies()
    {
        $client1 = Client::factory()->create([
            'name' => 'Empresa 1'
        ]);

        Supply::factory()->create([
            'client_id' => $client1->id
        ]);

        Livewire::test(ClientTable::class)
            ->call('destroy', $client1)
            ->assertRedirect(route('clients.index'));

        $this->assertEquals(
            'Não é possível deletar um cliente que possui insumos ou ordens associadas.',
            session('error')
        );

        $this->assertDatabaseHas('clients', [
            'name' => 'Empresa 1'
        ]);
    }

    // Test that the user is redirected after deleting a client
    public function test_user_is_redirected_after_client_deletion()
    {
        $client1 = Client::factory()->create([
            'name' => 'Empresa 1'
        ]);

        Livewire::test(ClientTable::class)
            ->call('destroy', $client1)
            ->assertRedirect(route('clients.index'));
    }
}
