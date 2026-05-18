<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Supply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_client_with_valid_data()
    {
        $response = $this->post('/clients', [
            'name' => 'Cliente Teste',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('clients', ['name' => 'Cliente Teste']);
    }

    public function test_do_not_create_client_with_invalid_data()
    {
        $response = $this->post('/clients', [
            'name' => '',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_list_clients()
    {
        Client::factory()->create([
            'name' => 'Cliente Lista',
        ]);

        $response = $this->get('/clients');

        $response->assertStatus(200);
        $response->assertSee('Cliente Lista');
    }

    public function test_access_create_client_page()
    {
        $response = $this->get('/clients/create');

        $response->assertStatus(200);
        $response->assertSee('Criar Cliente');
    }

    public function test_access_edit_client_page()
    {
        $client = Client::factory()->create([
            'name' => 'Cliente Edicao',
        ]);

        $response = $this->get("/clients/{$client->id}/edit");

        $response->assertStatus(200);
        $response->assertSee('Cliente Edicao');
    }

    public function test_update_client()
    {
        $client = Client::factory()->create([
            'name' => 'Cliente Antigo',
        ]);

        $response = $this->put("/clients/{$client->id}", [
            'name' => 'Cliente Novo',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('clients', ['id' => $client->id, 'name' => 'Cliente Novo']);
    }

    public function test_delete_client()
    {
        $client = Client::factory()->create([
            'name' => 'Cliente Deleta',
        ]);

        $response = $this->delete("/clients/{$client->id}");

        $response->assertStatus(302);
        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }

    public function test_client_has_supplies()
    {
        $client = Client::factory()->create();
        $supply = Supply::factory()->create([
            'client_id' => $client->id,
        ]);

        $this->assertTrue($client->supplies->contains($supply));
    }
}
