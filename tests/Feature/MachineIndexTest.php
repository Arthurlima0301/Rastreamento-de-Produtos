<?php

namespace Tests\Feature;

use App\Livewire\Machines\MachineTable;
use App\Models\Machine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MachineIndexTest extends TestCase
{
    use RefreshDatabase;

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
