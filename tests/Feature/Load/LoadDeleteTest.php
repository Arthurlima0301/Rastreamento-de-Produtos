<?php

use App\Livewire\Loads\LoadTable;
use App\Models\Load;
use App\Models\Roll;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LoadDeleteTest extends TestCase
{
    use RefreshDatabase;

    // Test that the load index page can be rendered before deleting.
    public function test_load_index_page_can_be_rendered()
    {
        $response = $this->get(route('loads.index'));

        $response->assertStatus(200);
        $response->assertSee('loads.load-table');
    }

    // Test that deleting a load releases its rolls back to stock.
    public function test_load_can_be_deleted()
    {
        $load = Load::factory()->create();

        $roll = Roll::factory()->create([
            'load_id' => $load->id,
            'status' => 'CORTADA',
            'defect' => 'Rasgo',
            'defect_weight' => 50,
        ]);

        Livewire::test(LoadTable::class)
            ->call('deleteLoad', $load)
            ->assertRedirect(route('loads.index'));

        $this->assertDatabaseMissing('loads', [
            'id' => $load->id,
        ]);

        $this->assertDatabaseHas('rolls', [
            'id' => $roll->id,
            'load_id' => null,
            'status' => 'EM_ESTOQUE',
            'defect' => null,
            'defect_weight' => null,
        ]);
    }
}
