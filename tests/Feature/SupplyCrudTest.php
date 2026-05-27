<?php

namespace Tests\Feature;

use App\Livewire\Supplies\SupplyForm;
use App\Livewire\Supplies\SupplyTable;
use App\Models\Client;
use App\Models\Supply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
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

        Livewire::test(SupplyForm::class)
            ->set('supply_code', $attributes['supply_code'])
            ->set('name', $attributes['name'])
            ->set('unit_of_measure', $attributes['unit_of_measure'])
            ->set('client_id', $attributes['client_id'])
            ->call('save')
            ->assertRedirect(route('supplies.index'));

        $this->assertDatabaseHas('supplies', [
            'supply_code' => 'ABC123',
            'client_id' => $client->id,
        ]);
    }

    public function test_do_not_create_supply_with_invalid_data()
    {
        Livewire::test(SupplyForm::class)
            ->set('supply_code', '')
            ->set('name', '')
            ->set('unit_of_measure', '')
            ->set('client_id', null)
            ->call('save')
            ->assertHasErrors(['supply_code', 'name', 'unit_of_measure', 'client_id']);
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

        Livewire::test(SupplyForm::class, ['supplyId' => $supply->id])
            ->set('supply_code', 'UPD1')
            ->set('name', 'Novo')
            ->set('unit_of_measure', 'kg')
            ->set('client_id', $client->id)
            ->call('save')
            ->assertRedirect(route('supplies.index'));

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

        Livewire::test(SupplyTable::class)
            ->call('destroy', $supply->id)
            ->assertRedirect(route('supplies.index'));

        $this->assertDatabaseMissing('supplies', ['id' => $supply->id]);
    }
}
