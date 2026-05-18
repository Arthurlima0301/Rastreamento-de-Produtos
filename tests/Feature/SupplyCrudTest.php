<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Supply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupplyCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_supply_with_valid_data()
    {
        $client = Client::factory()->create();

        $attributes = Supply::factory()->raw([
            'supply_code' => 'ABC123',
            'name' => 'Teste',
            'unit_of_measure' => 'kg',
            'client_id' => $client->id,
        ]);

        $response = $this->post('/supplies', $attributes);

        $response->assertStatus(302);
        $this->assertDatabaseHas('supplies', [
            'supply_code' => 'ABC123',
            'client_id' => $client->id,
        ]);
    }

    public function test_do_not_create_supply_with_invalid_data()
    {
        $response = $this->post('/supplies', [
            'supply_code' => '',
            'name' => '',
            'unit_of_measure' => '',
            'client_id' => '',
        ]);

        $response->assertSessionHasErrors(['supply_code', 'name', 'unit_of_measure', 'client_id']);
    }

    public function test_list_supplies()
    {
        Supply::factory()->create([
            'supply_code' => 'LISTA1',
            'name' => 'Teste Lista',
            'unit_of_measure' => 'kg',
        ]);

        $response = $this->get('/supplies');
        $response->assertStatus(200);
        $response->assertSee('LISTA1');
    }

    public function test_update_supply()
    {
        $client = Client::factory()->create();

        $supply = Supply::factory()->create([
            'supply_code' => 'UPD1',
            'name' => 'Antigo',
            'unit_of_measure' => 'kg',
        ]);

        $response = $this->put("/supplies/{$supply->id}", [
            'supply_code' => 'UPD1',
            'name' => 'Novo',
            'unit_of_measure' => 'kg',
            'client_id' => $client->id,
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('supplies', [
            'id' => $supply->id,
            'name' => 'Novo',
            'client_id' => $client->id,
        ]);
    }

    public function test_supply_belongs_to_client()
    {
        $client = Client::factory()->create();

        $supply = Supply::factory()->create([
            'client_id' => $client->id,
        ]);

        $this->assertTrue($supply->client->is($client));
    }

    public function test_delete_supply()
    {
        $supply = Supply::factory()->create([
            'supply_code' => 'DEL1',
            'name' => 'Teste Deleta',
            'unit_of_measure' => 'kg',
        ]);

        $response = $this->delete("/supplies/{$supply->id}");
        $response->assertStatus(302);
        $this->assertDatabaseMissing('supplies', ['id' => $supply->id]);
    }
}
