<?php

use App\Livewire\Supplies\SupplyTable;
use App\Models\Client;
use App\Models\Supply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SupplyReadTest extends TestCase
{
    use RefreshDatabase;

    // Test that the supply index page and table component can be rendered.
    public function test_supply_index_page_can_be_rendered()
    {
        $response = $this->get(route('supplies.index'));

        $response->assertStatus(200);
        $response->assertSee('Insumos');
        $response->assertSee('supplies.supply-table');
    }

    // Test that supply data is listed on the index page.
    public function test_supply_all_data_is_displayed()
    {
        $client = Client::factory()->create([
            'name' => 'Empresa 1',
        ]);

        Supply::factory()->create([
            'supply_code' => 'SUP-100',
            'name' => 'Cola Hotmelt',
            'unit_of_measure' => 'kg',
            'client_id' => $client->id,
        ]);

        Supply::factory()->create([
            'supply_code' => 'SUP-200',
            'name' => 'Fita Kraft',
            'unit_of_measure' => 'un',
            'client_id' => $client->id,
        ]);

        $response = $this->get(route('supplies.index'));

        $response->assertSee('SUP-100');
        $response->assertSee('Cola Hotmelt');
        $response->assertSee('SUP-200');
        $response->assertSee('Fita Kraft');
        $response->assertSee('Empresa 1');
    }

    // Test search functionality on the supply table.
    public function test_supply_search_functionality()
    {
        Supply::factory()->create([
            'name' => 'Cola Hotmelt',
        ]);

        Supply::factory()->create([
            'name' => 'Fita Kraft',
        ]);

        Livewire::test(SupplyTable::class)
            ->set('search', 'Cola')
            ->assertSee('Cola Hotmelt')
            ->assertDontSee('Fita Kraft');
    }
}
