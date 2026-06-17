<?php

use App\Livewire\Loads\SelectedRollsList;
use App\Models\Load;
use App\Models\Machine;
use App\Models\Roll;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LoadCreateTest extends TestCase
{
    use RefreshDatabase;

    // Test that the load creation page and its child component can be rendered.
    public function test_load_create_page_can_be_rendered()
    {
        $response = $this->get(route('loads.create'));

        $response->assertStatus(200);
        $response->assertSee('Criar Carga');
        $response->assertSee('loads.selected-rolls-list');
    }

    // Test that a valid load can be created with selected rolls.
    public function test_load_can_be_created_with_valid_data()
    {
        $machine = Machine::factory()->create([
            'name' => 'Maquina Corte',
            'abbreviation' => 'C',
        ]);

        $roll = Roll::factory()->create([
            'label' => '007202026-0001',
            'weight' => 120,
            'status' => 'EM_ESTOQUE',
            'load_id' => null,
        ]);

        Livewire::test(SelectedRollsList::class)
            ->call('addRoll', $roll->id, $roll->label, $roll->formatted_weight)
            ->set('selectedMachineId', $machine->id)
            ->set('selectedTurn', 'DIURNO')
            ->set('selectedCuttedAt', '2026-06-06')
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('loads.index'));

        $this->assertDatabaseHas('loads', [
            'machine_id' => $machine->id,
            'turn' => 'DIURNO',
            'cutted_at' => '2026-06-06 00:00:00',
        ]);
    }

    // Test validation errors when required load data is missing.
    public function test_load_creation_validation_errors_for_missing_data()
    {
        Livewire::test(SelectedRollsList::class)
            ->call('save')
            ->assertHasErrors([
                'selectedMachineId' => 'required',
                'selectedTurn' => 'required',
                'selectedCuttedAt' => 'required',
                'selectedRolls' => 'required',
            ]);

        $this->assertDatabaseCount('loads', 0);
    }

    // Test that the user is redirected after creating a load.
    public function test_user_is_redirected_after_load_creation()
    {
        $machine = Machine::factory()->create();
        $roll = Roll::factory()->create([
            'status' => 'EM_ESTOQUE',
            'load_id' => null,
        ]);

        Livewire::test(SelectedRollsList::class)
            ->set('selectedRolls', [$roll->id => $this->selectedRollData($roll)])
            ->set('selectedMachineId', $machine->id)
            ->set('selectedTurn', 'VESPERTINO')
            ->set('selectedCuttedAt', '2026-06-07')
            ->call('save')
            ->assertRedirect(route('loads.index'));
    }

    // Test that machine, turn, date and rolls are associated with the created load.
    public function test_machine_turn_date_and_rolls_are_associated_with_load()
    {
        $machine = Machine::factory()->create();
        $rollA = Roll::factory()->create(['status' => 'EM_ESTOQUE', 'load_id' => null]);
        $rollB = Roll::factory()->create(['status' => 'EM_ESTOQUE', 'load_id' => null]);

        Livewire::test(SelectedRollsList::class)
            ->set('selectedRolls', [
                $rollA->id => $this->selectedRollData($rollA),
                $rollB->id => $this->selectedRollData($rollB),
            ])
            ->set('selectedMachineId', $machine->id)
            ->set('selectedTurn', 'NOTURNO')
            ->set('selectedCuttedAt', '2026-06-08')
            ->call('save')
            ->assertRedirect(route('loads.index'));

        $load = Load::query()->firstOrFail();

        $this->assertDatabaseHas('loads', [
            'id' => $load->id,
            'machine_id' => $machine->id,
            'turn' => 'NOTURNO',
            'cutted_at' => '2026-06-08 00:00:00',
        ]);

        $this->assertDatabaseHas('rolls', ['id' => $rollA->id, 'load_id' => $load->id]);
        $this->assertDatabaseHas('rolls', ['id' => $rollB->id, 'load_id' => $load->id]);
    }

    // Test that selected rolls are marked as cut after load creation.
    public function test_selected_roll_statuses_are_changed_to_cut()
    {
        $machine = Machine::factory()->create();
        $roll = Roll::factory()->create([
            'status' => 'EM_ESTOQUE',
            'load_id' => null,
        ]);

        Livewire::test(SelectedRollsList::class)
            ->set('selectedRolls', [$roll->id => $this->selectedRollData($roll)])
            ->set('selectedMachineId', $machine->id)
            ->set('selectedTurn', 'DIURNO')
            ->set('selectedCuttedAt', '2026-06-09')
            ->call('save')
            ->assertRedirect(route('loads.index'));

        $this->assertDatabaseHas('rolls', [
            'id' => $roll->id,
            'status' => 'CORTADA',
        ]);
    }

    // Test that roll defects are persisted during load creation.
    public function test_roll_defects_are_added_to_load_rolls()
    {
        $machine = Machine::factory()->create();
        $roll = Roll::factory()->create([
            'status' => 'EM_ESTOQUE',
            'load_id' => null,
            'defect' => null,
            'defect_weight' => null,
        ]);

        Livewire::test(SelectedRollsList::class)
            ->set('selectedRolls', [$roll->id => $this->selectedRollData($roll, 'Rasgo', 50)])
            ->set('selectedMachineId', $machine->id)
            ->set('selectedTurn', 'DIURNO')
            ->set('selectedCuttedAt', '2026-06-10')
            ->call('save')
            ->assertRedirect(route('loads.index'));

        $this->assertDatabaseHas('rolls', [
            'id' => $roll->id,
            'defect' => 'Rasgo',
            'defect_weight' => 50,
        ]);
    }

    // Test that a roll cannot be added twice to the selected list.
    public function test_cannot_add_duplicate_roll_to_selected_rolls()
    {
        $roll = Roll::factory()->create([
            'label' => '007202026-0002',
        ]);

        Livewire::test(SelectedRollsList::class)
            ->call('addRoll', $roll->id, $roll->label, $roll->formatted_weight)
            ->call('addRoll', $roll->id, $roll->label, $roll->formatted_weight)
            ->assertHasErrors('selectedRolls')
            ->assertSet('selectedRolls', [
                $roll->id => $this->selectedRollData($roll),
            ]);
    }

    // Test that a load selection cannot contain more than six rolls.
    public function test_cannot_add_more_than_six_rolls_to_selected_rolls()
    {
        $rolls = Roll::factory()->count(7)->create();
        $component = Livewire::test(SelectedRollsList::class);

        foreach ($rolls as $roll) {
            $component->call('addRoll', $roll->id, $roll->label, $roll->formatted_weight);
        }

        $component->assertHasErrors('selectedRolls');

        $this->assertCount(6, $component->get('selectedRolls'));
    }

    private function selectedRollData(Roll $roll, ?string $defect = null, ?int $defectWeight = null): array
    {
        return [
            'id' => $roll->id,
            'label' => $roll->label,
            'weight' => $roll->formatted_weight,
            'defect' => $defect,
            'defect_weight' => $defectWeight,
        ];
    }
}
