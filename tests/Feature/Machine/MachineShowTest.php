<?php

use App\Models\Load;
use App\Models\Machine;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class MachineShowTest extends TestCase 
{
    use RefreshDatabase;

    // Test that the machine show page can be rendered
    public function test_machine_show_page_can_be_rendered() 
    {
        $machine = Machine::factory()->create([
            'name' => 'Máquina 1', 
            'abbreviation' => 'M1'
        ]);

        $response = $this->get(route('machines.show', $machine->id));
        $response->assertStatus(200);
        $response->assertSee('Máquina 1');
        $response->assertSee('M1');
    }


    // Testa if machine load is rendered
    public function test_machine_load_is_rendered() 
    {
        $machine = Machine::factory()->create([
            'name' => 'Máquina 1', 
            'abbreviation' => 'M1'
        ]);

        Load::factory()->create([
            'id' => 1,
            'machine_id' => $machine->id
        ]);

        $response = $this->get(route('machines.show', $machine->id));
        $response->assertStatus(200);
        $response->assertSee('M1-1');
    }
}