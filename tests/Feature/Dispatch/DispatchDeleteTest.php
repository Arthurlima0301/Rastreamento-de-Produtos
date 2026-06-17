<?php

use App\Livewire\Dispatches\DispatchTable;
use App\Models\Dispatch;
use App\Models\DispatchItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DispatchDeleteTest extends TestCase
{
    use RefreshDatabase;

    // Test that the dispatch index page can be rendered before deleting.
    public function test_dispatch_index_page_can_be_rendered()
    {
        $response = $this->get(route('dispatches.index'));

        $response->assertStatus(200);
        $response->assertSee('dispatches.dispatch-table');
    }

    // Test that a dispatch can be deleted with its dispatch items.
    public function test_dispatch_can_be_deleted()
    {
        $dispatch = Dispatch::factory()->create([
            'invoice' => 'NF100',
        ]);

        $dispatchItem = DispatchItem::factory()->create([
            'dispatch_id' => $dispatch->id,
        ]);

        Livewire::test(DispatchTable::class)
            ->call('destroy', $dispatch)
            ->assertRedirect(route('dispatches.index'));

        $this->assertDatabaseMissing('dispatches', [
            'id' => $dispatch->id,
        ]);

        $this->assertDatabaseMissing('dispatch_items', [
            'id' => $dispatchItem->id,
        ]);
    }
}
