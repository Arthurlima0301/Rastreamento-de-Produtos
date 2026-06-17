<?php

use App\Livewire\Machines\MachineForm;
use App\Models\Machine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MachineUpdateTest extends TestCase
{
    use RefreshDatabase;

    // Test that the machine edit page can be rendered
    public function test_machine_edit_page_can_be_rendered()
    {
        $machine = Machine::factory()->create([
            'name' => 'Maquina 1',
            'abbreviation' => 'A',
        ]);

        $response = $this->get(route('machines.edit', $machine));

        $response->assertStatus(200);
        $response->assertSee('Editar Máquina');
        $response->assertSee('Maquina 1');
        $response->assertSee('A');
    }

    // Test that a machine can be updated successfully
    public function test_machine_can_be_updated()
    {
        $machine = Machine::factory()->create([
            'name' => 'Maquina 1',
            'abbreviation' => 'A',
        ]);

        Livewire::test(MachineForm::class)
            ->set('machineId', $machine->id)
            ->set('name', 'Maquina 1 Atualizada')
            ->set('abbreviation', 'B')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('machines', [
            'name' => 'Maquina 1 Atualizada',
            'abbreviation' => 'B',
        ]);

        $this->assertDatabaseMissing('machines', [
            'name' => 'Maquina 1',
            'abbreviation' => 'A',
        ]);
    }

    // Test that a machine cannot be updated with invalid data
    public function test_machine_cannot_be_updated_with_invalid_data()
    {
        $machine = Machine::factory()->create([
            'name' => 'Maquina 1',
            'abbreviation' => 'A',
        ]);

        Machine::factory()->create([
            'name' => 'Maquina 2',
            'abbreviation' => 'B',
        ]);

        Livewire::test(MachineForm::class)
            ->set('machineId', $machine->id)
            ->set('name', '')
            ->set('abbreviation', 'B')
            ->call('save')
            ->assertHasErrors(['name' => 'required', 'abbreviation' => 'unique']);

        $this->assertDatabaseHas('machines', [
            'name' => 'Maquina 1',
            'abbreviation' => 'A',
        ]);
    }
}
