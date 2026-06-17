<?php

use App\Livewire\Machines\MachineTable;
use App\Models\Load;
use App\Models\Machine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MachineDeleteTest extends TestCase
{
    use RefreshDatabase;

    // Test that the machine index page can be rendered
    public function test_machine_index_page_can_be_rendered()
    {
        $response = $this->get(route('machines.index'));

        $response->assertStatus(200);
        $response->assertSee('machines.machine-table');
    }

    // Test that a machine can be deleted successfully
    public function test_machine_can_be_deleted()
    {
        $machine = Machine::factory()->create([
            'name' => 'Maquina 1',
            'abbreviation' => 'A',
        ]);

        Machine::factory()->create([
            'name' => 'Maquina 2',
            'abbreviation' => 'B',
        ]);

        Livewire::test(MachineTable::class)
            ->call('destroy', $machine)
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('machines', [
            'name' => 'Maquina 1',
        ]);

        $this->assertDatabaseHas('machines', [
            'name' => 'Maquina 2',
        ]);
    }

    // Test that a machine cannot be deleted when it has loads
    public function test_machine_cannot_be_deleted_when_it_has_loads()
    {
        $machine = Machine::factory()->create([
            'name' => 'Maquina 1',
            'abbreviation' => 'A',
        ]);

        Load::factory()->create([
            'machine_id' => $machine->id,
        ]);

        Livewire::test(MachineTable::class)
            ->call('destroy', $machine)
            ->assertRedirect(route('machines.index'));

        $this->assertEquals(
            'Não é possível deletar esta máquina, pois ela está associada a um ou mais cargas.',
            session('error')
        );

        $this->assertDatabaseHas('machines', [
            'name' => 'Maquina 1',
        ]);
    }

    // Test that the user is redirected after deleting a machine
    public function test_user_is_redirected_after_machine_deletion()
    {
        $machine = Machine::factory()->create([
            'name' => 'Maquina 1',
            'abbreviation' => 'A',
        ]);

        Livewire::test(MachineTable::class)
            ->call('destroy', $machine)
            ->assertRedirect(route('machines.index'));
    }
}
