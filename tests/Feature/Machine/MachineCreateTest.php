<?php

use App\Livewire\Machines\MachineForm;
use App\Models\Machine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MachineCreateTest extends TestCase
{
    use RefreshDatabase;

    // Test that the machine creation page can be rendered
    public function test_machine_page_can_be_rendered()
    {
        $response = $this->get(route('machines.create'));

        $response->assertStatus(200);
        $response->assertSee('Criar Máquina');
    }

    // Test that a machine can be created successfully
    public function test_machine_can_be_created()
    {
        Livewire::test(MachineForm::class)
            ->set('name', 'Maquina 1')
            ->set('abbreviation', 'A')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('machines', [
            'name' => 'Maquina 1',
            'abbreviation' => 'A',
        ]);
    }

    // Test that the user is redirected after successfully creating a machine
    public function test_user_is_redirected_after_machine_creation()
    {
        Livewire::test(MachineForm::class)
            ->set('name', 'Maquina 1')
            ->set('abbreviation', 'A')
            ->call('save')
            ->assertRedirect(route('machines.index'));
    }

    // Test that validation errors are shown when creating a machine with invalid data
    public function test_machine_creation_validation_errors()
    {
        Machine::factory()->create([
            'name' => 'Maquina 1',
            'abbreviation' => 'A',
        ]);

        Livewire::test(MachineForm::class)
            ->set('name', '')
            ->set('abbreviation', 'A')
            ->call('save')
            ->assertHasErrors(['name' => 'required', 'abbreviation' => 'unique']);

        $this->assertDatabaseMissing('machines', [
            'name' => '',
        ]);
    }
}
