<?php

use App\Livewire\Machines\MachineTable;
use App\Models\Machine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MachineReadTest extends TestCase
{
    use RefreshDatabase;

    // Test that the machine index page can be rendered
    public function test_machine_index_page_can_be_rendered()
    {
        $response = $this->get(route('machines.index'));

        $response->assertStatus(200);
        $response->assertSee('machines.machine-table');
    }

    // Test that all machine data is displayed
    public function test_machine_all_data_is_displayed()
    {
        Machine::factory()->create([
            'name' => 'Maquina 1',
            'abbreviation' => 'A',
        ]);

        Machine::factory()->create([
            'name' => 'Maquina 2',
            'abbreviation' => 'B',
        ]);

        $response = $this->get(route('machines.index'));

        $response->assertSee('Maquina 1');
        $response->assertSee('Maquina 2');
    }

    // Test search functionality on the machine index page
    public function test_machine_search_functionality()
    {
        Machine::factory()->create([
            'name' => 'Maquina 1',
            'abbreviation' => 'A',
        ]);

        Machine::factory()->create([
            'name' => 'Maquina 2',
            'abbreviation' => 'B',
        ]);

        Livewire::test(MachineTable::class)
            ->set('search', 'Maquina 1')
            ->assertSee('Maquina 1')
            ->assertDontSee('Maquina 2');
    }
}
