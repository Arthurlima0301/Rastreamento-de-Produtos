<?php

namespace Tests\Feature;

use App\Livewire\Machines\MachineTable;
use App\Models\Machine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;
use Tests\TestCase;

class MachineCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_machines_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('machines', [
            'id',
            'name',
            'acronym',
            'created_at',
            'updated_at',
        ]));
    }

    public function test_create_machine_with_valid_data()
    {
        $response = $this->post('/machines', [
            'name' => 'Cortadeira',
            'acronym' => 'C',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('machines', [
            'name' => 'Cortadeira',
            'acronym' => 'C',
        ]);
    }

    public function test_do_not_create_machine_with_invalid_data()
    {
        $response = $this->post('/machines', [
            'name' => '',
            'acronym' => 'AB',
        ]);

        $response->assertSessionHasErrors(['name', 'acronym']);
    }

    public function test_list_machines()
    {
        Machine::factory()->create([
            'name' => 'Máquina Lista',
            'acronym' => 'L',
        ]);

        $response = $this->get('/machines');

        $response->assertStatus(200);
        $response->assertSee('Máquina Lista');
        $response->assertSee('L');
    }

    public function test_access_create_machine_page()
    {
        $response = $this->get('/machines/create');

        $response->assertStatus(200);
        $response->assertSee('Criar Máquina');
    }

    public function test_show_machine()
    {
        $machine = Machine::factory()->create([
            'name' => 'Máquina Detalhe',
            'acronym' => 'D',
        ]);

        $response = $this->get("/machines/{$machine->id}");

        $response->assertStatus(200);
        $response->assertSee('Máquina Detalhe');
        $response->assertSee('D');
    }

    public function test_access_edit_machine_page()
    {
        $machine = Machine::factory()->create([
            'name' => 'Máquina Edicao',
            'acronym' => 'E',
        ]);

        $response = $this->get("/machines/{$machine->id}/edit");

        $response->assertStatus(200);
        $response->assertSee('Máquina Edicao');
        $response->assertSee('E');
    }

    public function test_update_machine()
    {
        $machine = Machine::factory()->create([
            'name' => 'Máquina Antiga',
            'acronym' => 'A',
        ]);

        $response = $this->put("/machines/{$machine->id}", [
            'name' => 'Máquina Nova',
            'acronym' => 'N',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('machines', [
            'id' => $machine->id,
            'name' => 'Máquina Nova',
            'acronym' => 'N',
        ]);
    }

    public function test_delete_machine()
    {
        $machine = Machine::factory()->create([
            'name' => 'Máquina Deleta',
            'acronym' => 'X',
        ]);

        $response = $this->delete("/machines/{$machine->id}");

        $response->assertStatus(302);
        $this->assertDatabaseMissing('machines', ['id' => $machine->id]);
    }

    public function test_filter_machines_by_search_prefix()
    {
        Machine::factory()->create([
            'name' => 'Cortadeira',
            'acronym' => 'C',
        ]);
        Machine::factory()->create([
            'name' => 'Rebobinadeira',
            'acronym' => 'R',
        ]);

        Livewire::test(MachineTable::class)
            ->set('search', 'Corta')
            ->assertSee('Cortadeira')
            ->assertDontSee('Rebobinadeira');
    }
}
