<?php

use App\Livewire\Rolls\RollTable;
use App\Models\Roll;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class RollReadTest extends TestCase
{
    use RefreshDatabase;

    // Test that the roll index page and table component can be rendered.
    public function test_roll_index_page_can_be_rendered()
    {
        $response = $this->get(route('rolls.index'));

        $response->assertStatus(200);
        $response->assertSee('Bobinas');
        $response->assertSee('rolls.roll-table');
    }

    // Test that roll data is listed on the index page.
    public function test_roll_all_data_is_displayed()
    {
        Roll::factory()->create([
            'label' => '007202026-0001',
            'weight' => 150,
            'status' => 'EM_ESTOQUE',
        ]);

        Roll::factory()->create([
            'label' => '007202026-0002',
            'weight' => 200,
            'status' => 'CORTADA',
        ]);

        $response = $this->get(route('rolls.index'));

        $response->assertSee('007202026-0001');
        $response->assertSee('007202026-0002');
        $response->assertSee('EM_ESTOQUE');
        $response->assertSee('CORTADA');
    }

    // Test search functionality on the roll table.
    public function test_roll_search_functionality()
    {
        Roll::factory()->create([
            'label' => '007202026-0001',
        ]);

        Roll::factory()->create([
            'label' => '007202026-0002',
        ]);

        Livewire::test(RollTable::class)
            ->set('search', '007202026-0001')
            ->assertSee('007202026-0001')
            ->assertDontSee('007202026-0002');
    }
}
