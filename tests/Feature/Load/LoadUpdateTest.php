<?php

use App\Livewire\Loads\EditLoad;
use App\Livewire\Loads\LoadAddRolls;
use App\Livewire\Loads\LoadRolls;
use App\Livewire\Loads\LoadShow;
use App\Models\Load;
use App\Models\Machine;
use App\Models\Pallet;
use App\Models\Roll;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LoadUpdateTest extends TestCase
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
    public function test_load_update_rejects_invalid_data()
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

    // Test remove roll functionality in edit load component.
    public function test_load_roll_can_be_removed()
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

        $roll = Roll::factory()->create([
            'id' => 1,
            'label' => 'Rolo 1',
            'weight' => 1000,
            'status' => 'CORTADA',
            'load_id' => $load->id,
            'defect' => 'Rasgo',
            'defect_weight' => 50,
        ]);

        Livewire::test(LoadRolls::class, ['load' => $load])
            ->call('removeRoll', $roll->id)
            ->assertHasNoErrors()
            ->assertDontSee('Rolo 1');

        $this->assertDatabaseHas('rolls', [
            'id' => $roll->id,
            'label' => 'Rolo 1',
            'status' => 'EM_ESTOQUE',
            'load_id' => null,
            'defect' => 'Rasgo',
            'defect_weight' => 50,
        ]);
    }

    // Test that an available roll can be added to an existing load.
    public function test_load_roll_can_be_added()
    {


        $load = Load::factory()->create();
        Roll::factory(5)->create([
            'status' => 'CORTADA',
            'load_id' => $load->id,
        ]);


        $newRoll = Roll::factory()->create([
            'label' => 'Rolo 2',
            'status' => 'EM_ESTOQUE',
            'load_id' => null,
        ]);

        Livewire::test(LoadAddRolls::class, ['load' => $load])
            ->call('addRoll', $newRoll->id)
            ->assertHasNoErrors()
            ->assertSee('Bobina adicionada');

        $this->assertDatabaseHas('rolls', [
            'id' => $newRoll->id,
            'label' => 'Rolo 2',
            'status' => 'CORTADA',
            'load_id' => $load->id,
        ]);
    }

    // Test that a roll cannot be added when the load already has six rolls.
    public function test_load_roll_cannot_be_added_when_load_limit_is_reached()
    {
        $load = Load::factory()->create();

        Roll::factory()->count(6)->create([
            'status' => 'CORTADA',
            'load_id' => $load->id,
        ]);

        $roll = Roll::factory()->create([
            'label' => 'Rolo excedente',
            'status' => 'EM_ESTOQUE',
            'load_id' => null,
        ]);

        Livewire::test(LoadAddRolls::class, ['load' => $load])
            ->call('addRoll', $roll->id)
            ->assertHasNoErrors()
            ->assertSee('Limite de 6 bobinas');

        $this->assertDatabaseHas('rolls', [
            'id' => $roll->id,
            'label' => 'Rolo excedente',
            'status' => 'EM_ESTOQUE',
            'load_id' => null,
        ]);

        $this->assertSame(6, $load->rolls()->count());
    }

    // Test that a roll cannot be removed from a load that has pallets generated.
    public function test_load_roll_cannot_be_removed_when_pallets_exist()
    {


        $load = Load::factory()->create();

        $roll = Roll::factory()->create([
            'label' => 'Rolo 3',
            'status' => 'CORTADA',
            'load_id' => $load->id,
        ]);

        Pallet::factory()->create([
            'label' => 1,
            'load_id' => $load->id,
        ]);

        Livewire::test(LoadRolls::class, ['load' => $load])
            ->call('removeRoll', $roll->id)
            ->assertSee('Não é possível remover rolos de uma carga que já possui pallets gerados!');

        $this->assertDatabaseHas('rolls', [
            'id' => $roll->id,
            'label' => 'Rolo 3',
            'status' => 'CORTADA',
            'load_id' => $load->id,
        ]);
    }
}
