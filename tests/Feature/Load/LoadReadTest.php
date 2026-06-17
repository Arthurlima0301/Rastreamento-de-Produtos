<?php

use App\Livewire\Loads\LoadTable;
use App\Models\Load;
use App\Models\Machine;
use App\Models\Roll;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LoadReadTest extends TestCase
{
    use RefreshDatabase;

    // Test that the load index page and table component can be rendered.
    public function test_load_index_page_can_be_rendered()
    {
        $response = $this->get(route('loads.index'));

        $response->assertStatus(200);
        $response->assertSee('Cargas');
        $response->assertSee('loads.load-table');
    }

    // Test that load data is listed on the index page.
    public function test_load_all_data_is_displayed()
    {
        $machine = Machine::factory()->create([
            'name' => 'Maquina Corte',
            'abbreviation' => 'C',
        ]);

        $load = Load::factory()->create([
            'machine_id' => $machine->id,
            'turn' => 'DIURNO',
            'cutted_at' => '2026-06-06',
        ]);

        Roll::factory()->create([
            'load_id' => $load->id,
            'status' => 'CORTADA',
            'weight' => 120,
        ]);

        $response = $this->get(route('loads.index'));

        $response->assertSee('C-'.$load->id);
        $response->assertSee('06/06/2026');
        $response->assertSee('DIURNO');
        $response->assertSee('Maquina Corte');
        $response->assertSee('120,00');
    }

    // Test search functionality on the load table.
    public function test_load_search_functionality()
    {
        $matchedMachine = Machine::factory()->create([
            'abbreviation' => 'A',
        ]);

        $otherMachine = Machine::factory()->create([
            'abbreviation' => 'B',
        ]);

        $matchedLoad = Load::factory()->create([
            'machine_id' => $matchedMachine->id,
        ]);

        $otherLoad = Load::factory()->create([
            'machine_id' => $otherMachine->id,
        ]);

        Livewire::test(LoadTable::class)
            ->set('search', "A-{$matchedLoad->id}")
            ->assertSee("A-{$matchedLoad->id}")
            ->assertDontSee("B-{$otherLoad->id}");
    }
}
