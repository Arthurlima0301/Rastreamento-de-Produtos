<?php

use App\Livewire\Dispatches\EditDispatch;
use App\Models\Dispatch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DispatchUpdateTest extends TestCase
{
    use RefreshDatabase;

    // Test that the dispatch show page can be rendered with dispatch data.
    public function test_dispatch_show_page_can_be_rendered_for_update()
    {
        $dispatch = Dispatch::factory()->create([
            'invoice' => 'NF100',
            'dispatched_at' => '2026-06-01',
        ]);

        $response = $this->get(route('dispatches.show', $dispatch));

        $response->assertStatus(200);
        $response->assertSee('NF100');
        $response->assertSee('01/06/2026');
    }

    // Test that dispatch data can be updated.
    public function test_dispatch_can_be_updated()
    {
        $dispatch = Dispatch::factory()->create([
            'invoice' => 'NF100',
            'dispatched_at' => '2026-06-01',
        ]);

        Livewire::test(EditDispatch::class, ['dispatchId' => $dispatch->id])
            ->set('invoice', 'NF101')
            ->set('dispatched_at', '2026-06-02')
            ->call('save')
            ->assertHasNoErrors()
            ->assertSet('isEdited', false);

        $this->assertDatabaseHas('dispatches', [
            'id' => $dispatch->id,
            'invoice' => 'NF101',
            'dispatched_at' => '2026-06-02 00:00:00',
        ]);
    }

    // Test that invalid dispatch updates are rejected.
    public function test_dispatch_cannot_be_updated_with_invalid_data()
    {
        $dispatch = Dispatch::factory()->create([
            'invoice' => 'NF100',
            'dispatched_at' => '2026-06-01',
        ]);

        Livewire::test(EditDispatch::class, ['dispatchId' => $dispatch->id])
            ->set('invoice', '')
            ->set('dispatched_at', '')
            ->call('save')
            ->assertHasErrors(['invoice' => 'required', 'dispatched_at' => 'required']);

        $this->assertDatabaseHas('dispatches', [
            'id' => $dispatch->id,
            'invoice' => 'NF100',
            'dispatched_at' => '2026-06-01 00:00:00',
        ]);
    }
}
