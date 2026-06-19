<?php

use App\Livewire\Loads\EditLoad;
use App\Models\Load;
use App\Models\Machine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LoadEditTest extends TestCase
{
    use RefreshDatabase;

    // Test that the load show page renders the edit component with current data.
    public function test_load_show_page_can_be_rendered_with_edit_component()
    {
        $machine = Machine::factory()->create([
            'abbreviation' => 'M',
        ]);

        $load = Load::factory()->create([
            'id' => 1,
            'turn' => 'DIURNO',
            'machine_id' => $machine->id,
            'cutted_at' => '2026-06-26',
        ]);

        $response = $this->get(route('loads.show', $load->id));
        $response->assertStatus(200);
        $response->assertSee('M-1');
        $response->assertSee('DIURNO');
        $response->assertSee($machine->name);
        $response->assertSee('26/06/2026');
    }

    // Test that load data can be updated from the edit component.
    public function test_load_can_be_edited()
    {
        $machine1 = Machine::factory()->create([
            'abbreviation' => 'M',
        ]);

        $machine2 = Machine::factory()->create([
            'abbreviation' => 'S',
        ]);

        $load = Load::factory()->create([
            'id' => 1,
            'turn' => 'DIURNO',
            'machine_id' => $machine1->id,
            'cutted_at' => '2026-06-26',
        ]);

        Livewire::test(EditLoad::class, ['load' => $load])
            ->set('isEditing', true)
            ->set('form', [
                'cutted_at' => '2026-06-27',
                'turn' => 'NOTURNO',
                'machine_id' => $machine2->id,
            ])
            ->call('save')
            ->assertHasNoErrors()
            ->assertSet('isEditing', false)
            ->assertSee('S-1')
            ->assertSee('NOTURNO')
            ->assertSee($machine2->name)
            ->assertSee('27/06/2026');

        $this->assertDatabaseHas(
            'loads',
            [
                'id' => 1,
                'turn' => 'NOTURNO',
                'machine_id' => $machine2->id,
                'cutted_at' => '2026-06-27 00:00:00',
            ]
        );
    }

    // Test that invalid load updates are rejected.
    public function test_load_edit_rejects_invalid_data()
    {
        $machine = Machine::factory()->create([
            'abbreviation' => 'M',
        ]);

        $load = Load::factory()->create([
            'id' => 1,
            'turn' => 'DIURNO',
            'machine_id' => $machine->id,
            'cutted_at' => '2026-06-26',
        ]);

        Livewire::test(EditLoad::class, ['load' => $load])
            ->set('form', [
                'cutted_at' => 'invalid-date',
                'turn' => 'MADRUGADA',
                'machine_id' => 999,
            ])
            ->call('save')
            ->assertHasErrors([
                'form.cutted_at' => 'date',
                'form.turn' => 'in',
                'form.machine_id' => 'exists',
            ]);

        $this->assertDatabaseHas(
            'loads',
            [
                'id' => 1,
                'turn' => 'DIURNO',
                'machine_id' => $machine->id,
                'cutted_at' => '2026-06-26 00:00:00',
            ]
        );
    }
}
