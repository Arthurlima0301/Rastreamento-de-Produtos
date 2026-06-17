<?php

use App\Livewire\Dispatches\DispatchTable;
use App\Models\Dispatch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DispatchReadTest extends TestCase
{
    use RefreshDatabase;

    // Test that the dispatch index page and table component can be rendered.
    public function test_dispatch_index_page_can_be_rendered()
    {
        $response = $this->get(route('dispatches.index'));

        $response->assertStatus(200);
        $response->assertSee('dispatches.dispatch-table');
    }

    // Test that dispatch data is listed on the index page.
    public function test_dispatch_all_data_is_displayed()
    {
        Dispatch::factory()->create([
            'invoice' => 'NF100',
            'dispatched_at' => '2026-06-01',
        ]);

        Dispatch::factory()->create([
            'invoice' => 'NF200',
            'dispatched_at' => '2026-06-02',
        ]);

        $response = $this->get(route('dispatches.index'));

        $response->assertSee('NF100');
        $response->assertSee('NF200');
        $response->assertSee('01/06/2026');
    }

    // Test search functionality on the dispatch table.
    public function test_dispatch_search_functionality()
    {
        Dispatch::factory()->create([
            'invoice' => 'NF100',
        ]);

        Dispatch::factory()->create([
            'invoice' => 'NF200',
        ]);

        Livewire::test(DispatchTable::class)
            ->set('search', 'NF1')
            ->assertSee('NF100')
            ->assertDontSee('NF200');
    }
}
