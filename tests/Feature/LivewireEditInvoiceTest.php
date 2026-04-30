<?php

namespace Tests\Feature\Feature;

use App\Livewire\Dispatches\EditDispatchInvoice;
use App\Models\Dispatch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireEditInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */

    public function test_toggle_state_to_edit(): void 
    {   
         $dispatch = Dispatch::factory()->create(
            [
                'invoice' => 'N/A',
                'dispatched_at' => now(),
            ]
        );

        Livewire::test(EditDispatchInvoice::class, ['dispatchId' => $dispatch->id])
        ->call('edit')
        ->assertSet('isEdited', true);

    }
    
    public function test_toggle_state_to_not_edited(): void 
    {   
         $dispatch = Dispatch::factory()->create(
            [
                'invoice' => 'N/A',
                'dispatched_at' => now(),
            ]
        );

        Livewire::test(EditDispatchInvoice::class, ['dispatchId' => $dispatch->id])
        ->set('isEdited', true)
        ->call('cancel')
        ->assertSet('isEdited', false);

    }

    public function test_edit_invoice(): void
    {
        $dispatch = Dispatch::factory()->create(
            [
                'invoice' => 'N/A',
                'dispatched_at' => now(),
            ]
        );

        Livewire::test(EditDispatchInvoice::class, ['dispatchId' => $dispatch->id])
            ->set('invoice', '12345678')
            ->assertHasNoErrors()
            ->call('save');

        $this->assertDatabaseHas(
            'dispatches',
            [
                'id' => $dispatch->id,
                'invoice' => '12345678'
            ]
        );
    }

    public function test_dont_register_invoice_if_is_empty(): void
    {

        $dispatch = Dispatch::factory()->create(
            [
                'invoice' => 'N/A',
                'dispatched_at' => now(),
            ]
        );

        Livewire::test(EditDispatchInvoice::class, ['dispatchId' => $dispatch->id])
            ->set('invoice', '')
            ->call('save')
            ->assertHasErrors(['invoice' => 'required']);


        $this->assertDatabaseHas('dispatches', [
            'id' => $dispatch->id,
            'invoice' => 'N/A',
        ]);
    }
}
