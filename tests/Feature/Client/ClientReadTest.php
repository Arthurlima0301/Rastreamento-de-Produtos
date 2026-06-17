<?php

use App\Livewire\Clients\ClientTable;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;


class ClientReadTest extends TestCase
{
    use RefreshDatabase;

    // Test that the client index page can be rendered
    public function test_client_index_page_can_be_rendered()
    {
        $response = $this->get(route('clients.index'));
        $response->assertStatus(200);
        $response->assertSee('clients.client-table');
    }

    // Test that all client data is displayed
    public function test_client_all_data_is_displayed()
    {
        $client1 = Client::factory()->create([
            'name' => 'Empresa 1'
        ]);

        $client2 = Client::factory()->create([
            'name' => 'Empresa 2'
        ]);

        $response = $this->get(route('clients.index'));
        $response->assertSee('Empresa 1');
        $response->assertSee('Empresa 2');
    }


    // Test search functionality on the client index page
    public function test_client_search_functionality()
    {

        $client1 = Client::factory()->create([
            'name' => 'Empresa 1'
        ]);

        $client2 = Client::factory()->create([
            'name' => 'Empresa 2'
        ]);

        Livewire::test(ClientTable::class)
            ->set('search','Empresa 1')
            ->assertSee('Empresa 1')
            ->assertDontSee('Empresa 2');
    }
}
