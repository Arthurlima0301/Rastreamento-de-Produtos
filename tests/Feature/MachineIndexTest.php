<?php

namespace Tests\Feature;

use App\Livewire\Machines\MachineForm;
use App\Livewire\Machines\MachineTable;
use App\Models\Machine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MachineIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_machine_with_valid_data(): void
    {
        Livewire::test(MachineForm::class)
            ->set('name', 'Cortadeira')
            ->set('abbreviation', 'C')
            ->call('save')
            ->assertRedirect(route('machines.index'));

        $this->assertDatabaseHas('machines', [
            'name' => 'Cortadeira',
            'abbreviation' => 'C',
        ]);
    }

    public function test_do_not_create_machine_with_invalid_data(): void
    {
        Livewire::test(MachineForm::class)
            ->set('name', '')
            ->set('abbreviation', '')
            ->call('save')
            ->assertHasErrors([
                'name' => 'required',
                'abbreviation' => 'required',
            ]);
    }

    public function test_do_not_create_machine_with_duplicate_abbreviation(): void
    {
        Machine::factory()->create([
            'abbreviation' => 'C',
        ]);

        Livewire::test(MachineForm::class)
            ->set('name', 'Cortadeira Nova')
            ->set('abbreviation', 'C')
            ->call('save')
            ->assertHasErrors(['abbreviation' => 'unique']);
    }

    public function test_list_machines(): void
    {
        Machine::factory()->create([
            'name' => 'Cortadeira',
            'abbreviation' => 'C',
        ]);

        $response = $this->get('/machines');

        $response->assertStatus(200);
        $response->assertSee('Cortadeira');
    }

    public function test_access_create_machine_page(): void
    {
        $response = $this->get('/machines/create');

        $response->assertStatus(200);
        $response->assertSee('Criar Máquina');
    }

    public function test_access_edit_machine_page(): void
    {
        $machine = Machine::factory()->create([
            'name' => 'Cortadeira',
            'abbreviation' => 'C',
        ]);

        $response = $this->get("/machines/{$machine->id}/edit");

        $response->assertStatus(200);
        $response->assertSee('Cortadeira');
    }

    public function test_update_machine(): void
    {
        $machine = Machine::factory()->create([
            'name' => 'Cortadeira',
            'abbreviation' => 'C',
        ]);

        Livewire::test(MachineForm::class, ['machineId' => $machine->id])
            ->set('name', 'Laminadora')
            ->set('abbreviation', 'L')
            ->call('save')
            ->assertRedirect(route('machines.index'));

        $this->assertDatabaseHas('machines', [
            'id' => $machine->id,
            'name' => 'Laminadora',
            'abbreviation' => 'L',
        ]);
    }

    public function test_delete_machine(): void
    {
        $machine = Machine::factory()->create([
            'name' => 'Cortadeira',
            'abbreviation' => 'C',
        ]);

        Livewire::test(MachineTable::class)
            ->call('destroy', $machine->id)
            ->assertRedirect(route('machines.index'));

        $this->assertDatabaseMissing('machines', ['id' => $machine->id]);
    }

    public function test_filter_machines_by_search_prefix(): void
    {
        Machine::factory()->create([
            'name' => 'Cortadeira',
            'abbreviation' => 'C',
        ]);

        Machine::factory()->create([
            'name' => 'Laminadora',
            'abbreviation' => 'L',
        ]);

        Livewire::test(MachineTable::class)
            ->set('search', 'Corta')
            ->assertSee('Cortadeira')
            ->assertDontSee('Laminadora');
    }
}
