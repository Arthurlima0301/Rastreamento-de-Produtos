<?php

namespace Tests\Feature;

use App\Livewire\Loads\LoadCreate;
use App\Livewire\Loads\LoadTable;
use App\Livewire\Loads\SelectedRollsList;
use App\Models\ItemMaterial;
use App\Models\Load;
use App\Models\Machine;
use App\Models\Roll;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class RegisterLoadTest extends TestCase
{
    use RefreshDatabase;

    public function test_access_load_create_page(): void
    {
        $response = $this->get(route('loads.create'));

        $response->assertStatus(200);
        $response->assertSee('Criar Carga');
    }

    public function test_filter_load_creation_rolls_by_search_prefix(): void
    {
        $itemMaterial = ItemMaterial::factory()->create();

        Roll::factory()->create([
            'label' => '007202026-0001',
            'status' => 'EM_ESTOQUE',
            'item_material_id' => $itemMaterial->id,
        ]);

        Roll::factory()->create([
            'label' => '007202026-0002',
            'status' => 'EM_ESTOQUE',
            'item_material_id' => $itemMaterial->id,
        ]);

        Livewire::test(LoadCreate::class)
            ->set('search', '007202026-0001')
            ->assertSee('007202026-0001')
            ->assertDontSee('007202026-0002');
    }

    public function test_only_available_rolls_are_shown_on_load_create_page(): void
    {
        $itemMaterial = ItemMaterial::factory()->create();
        $load = Load::factory()->create();

        Roll::factory()->create([
            'label' => '007202026-0001',
            'status' => 'EM_ESTOQUE',
            'item_material_id' => $itemMaterial->id,
        ]);

        Roll::factory()->create([
            'label' => '007202026-0002',
            'status' => 'CORTADA',
            'item_material_id' => $itemMaterial->id,
        ]);

        Roll::factory()->create([
            'label' => '007202026-0003',
            'status' => 'EM_ESTOQUE',
            'load_id' => $load->id,
            'item_material_id' => $itemMaterial->id,
        ]);

        Livewire::test(LoadCreate::class)
            ->assertSee('007202026-0001')
            ->assertDontSee('007202026-0002')
            ->assertDontSee('007202026-0003');
    }

    public function test_create_load_with_selected_rolls(): void
    {
        $machine = Machine::factory()->create();
        $roll = Roll::factory()->create([
            'label' => '007202026-0001',
            'status' => 'EM_ESTOQUE',
            'load_id' => null,
        ]);

        Livewire::test(SelectedRollsList::class)
            ->call('addRoll', $roll->id, $roll->label, $roll->formatted_weight)
            ->set('selectedCuttedAt', '2026-06-06')
            ->set('selectedTurn', 'DIURNO')
            ->set('selectedMachineId', $machine->id)
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('loads.index'));

        $this->assertDatabaseHas('loads', [
            'cutted_at' => '2026-06-06 00:00:00',
            'turn' => 'DIURNO',
            'machine_id' => $machine->id,
            'observation' => null,
        ]);

        $load = Load::query()->firstOrFail();

        $this->assertDatabaseHas('rolls', [
            'id' => $roll->id,
            'load_id' => $load->id,
            'status' => 'CORTADA',
        ]);
    }

    public function test_do_not_create_load_without_rolls(): void
    {
        $machine = Machine::factory()->create();

        Livewire::test(SelectedRollsList::class)
            ->set('selectedCuttedAt', '2026-06-06')
            ->set('selectedTurn', 'DIURNO')
            ->set('selectedMachineId', $machine->id)
            ->call('save')
            ->assertHasErrors([
                'selectedRolls' => 'required',
            ]);

        $this->assertDatabaseCount('loads', 0);
    }

    public function test_delete_load(): void
    {
        $load = Load::factory()->create();
        $roll = Roll::factory()->create([
            'load_id' => $load->id,
        ]);

        Livewire::test(LoadTable::class)
            ->call('deleteLoad', $load)
            ->assertRedirect(route('loads.index'));

        $this->assertDatabaseCount('loads', 0);
        $this->assertDatabaseHas('rolls', [
            'id' => $roll->id,
            'load_id' => null,
        ]);
    }
}
