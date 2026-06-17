<?php

use App\Models\Load;
use App\Models\Machine;
use App\Models\Roll;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoadShowTest extends TestCase
{
    use RefreshDatabase;

    // Test that the load show page can be rendered.
    public function test_load_show_page_can_be_rendered()
    {
        $load = Load::factory()->create();

        $response = $this->get(route('loads.show', $load));

        $response->assertStatus(200);
        $response->assertSee('Detalhes da Carga');
    }

    // Test that load information and rolls are displayed on the show page.
    public function test_load_rolls_and_information_are_displayed()
    {
        $machine = Machine::factory()->create([
            'name' => 'Maquina Corte',
            'abbreviation' => 'C',
        ]);

        $load = Load::factory()->create([
            'machine_id' => $machine->id,
            'turn' => 'VESPERTINO',
            'cutted_at' => '2026-06-06',
        ]);

        Roll::factory()->create([
            'label' => '007202026-0003',
            'weight' => 150,
            'status' => 'CORTADA',
            'load_id' => $load->id,
            'defect' => 'Mancha',
            'defect_weight' => 25,
        ]);

        $response = $this->get(route('loads.show', $load));

        $response->assertSee('C-'.$load->id);
        $response->assertSee('06/06/2026');
        $response->assertSee('VESPERTINO');
        $response->assertSee('Maquina Corte');
        $response->assertSee('007202026-0003');
        $response->assertSee('Mancha');
        $response->assertSee('25');
    }
}
