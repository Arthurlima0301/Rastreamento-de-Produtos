<?php

use App\Livewire\Dispatches\SelectedSupplyItemsList;
use App\Models\Dispatch;
use App\Models\SupplyItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DispatchCreateTest extends TestCase
{
    use RefreshDatabase;

    // Test that the dispatch creation page and selected items component can be rendered.
    public function test_dispatch_create_page_can_be_rendered()
    {
        $response = $this->get(route('dispatches.create'));

        $response->assertStatus(200);
        $response->assertSee('dispatches.selected-supply-items-list');
        $response->assertSee('Selecionados');
    }

    // Test that a valid dispatch can be created.
    public function test_dispatch_can_be_created_with_valid_data()
    {
        $supplyItem = SupplyItem::factory()->create([
            'quantity' => 100,
        ]);

        Livewire::test(SelectedSupplyItemsList::class)
            ->set('selectedSupplyItems', [
                $supplyItem->id => $this->selectedSupplyItemData($supplyItem, 25),
            ])
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('dispatches.index'));

        $dispatch = Dispatch::query()->firstOrFail();

        $this->assertDatabaseHas('dispatch_items', [
            'dispatch_id' => $dispatch->id,
            'supply_item_id' => $supplyItem->id,
            'quantity' => 25,
        ]);
    }

    // Test validation errors when dispatch data is missing.
    public function test_dispatch_creation_validation_errors_for_missing_data()
    {
        $supplyItem = SupplyItem::factory()->create([
            'quantity' => 100,
        ]);

        Livewire::test(SelectedSupplyItemsList::class)
            ->call('save')
            ->assertHasErrors(['selectedSupplyItems' => 'required']);

        Livewire::test(SelectedSupplyItemsList::class)
            ->set('selectedSupplyItems', [
                $supplyItem->id => $this->selectedSupplyItemData($supplyItem, null),
            ])
            ->call('save')
            ->assertHasErrors(['selectedSupplyItems.'.$supplyItem->id.'.quantity' => 'required']);

        $this->assertDatabaseCount('dispatches', 0);
        $this->assertDatabaseCount('dispatch_items', 0);
    }

    // Test that the user is redirected after creating a dispatch.
    public function test_user_is_redirected_after_dispatch_creation()
    {
        $supplyItem = SupplyItem::factory()->create([
            'quantity' => 100,
        ]);

        Livewire::test(SelectedSupplyItemsList::class)
            ->set('selectedSupplyItems', [
                $supplyItem->id => $this->selectedSupplyItemData($supplyItem, 10),
            ])
            ->call('save')
            ->assertRedirect(route('dispatches.index'));
    }

    // Test that dispatch items are associated and balance is updated by consumption.
    public function test_dispatch_items_are_associated_and_balance_is_updated()
    {
        $supplyItem = SupplyItem::factory()->create([
            'quantity' => 100,
        ]);

        Livewire::test(SelectedSupplyItemsList::class)
            ->set('selectedSupplyItems', [
                $supplyItem->id => $this->selectedSupplyItemData($supplyItem, 40),
            ])
            ->call('save')
            ->assertRedirect(route('dispatches.index'));

        $dispatch = Dispatch::query()->firstOrFail();

        $this->assertDatabaseHas('dispatch_items', [
            'dispatch_id' => $dispatch->id,
            'supply_item_id' => $supplyItem->id,
            'quantity' => 40,
        ]);

        $this->assertEquals(60.0, (float) SupplyItem::withBalance()->find($supplyItem->id)->balance);
    }

    // Test that insufficient balance prevents dispatch creation.
    public function test_dispatch_cannot_consume_more_than_supply_item_balance()
    {
        $supplyItem = SupplyItem::factory()->create([
            'quantity' => 100,
        ]);

        Livewire::test(SelectedSupplyItemsList::class)
            ->set('selectedSupplyItems', [
                $supplyItem->id => $this->selectedSupplyItemData($supplyItem, 101),
            ])
            ->call('save')
            ->assertHasErrors('selectedSupplyItems');

        $this->assertDatabaseCount('dispatches', 0);
        $this->assertDatabaseCount('dispatch_items', 0);
    }

    // Test that a selected supply item is not duplicated in the list.
    public function test_dispatch_selection_does_not_duplicate_selected_supply_item()
    {
        $supplyItem = SupplyItem::factory()->create();

        Livewire::test(SelectedSupplyItemsList::class)
            ->call('selectSupplyItem', $supplyItem->id, $supplyItem->supply->name)
            ->call('selectSupplyItem', $supplyItem->id, $supplyItem->supply->name)
            ->assertSet('selectedSupplyItems', [
                $supplyItem->id => [
                    'id' => $supplyItem->id,
                    'supply_name' => $supplyItem->supply->name,
                    'quantity' => null,
                ],
            ]);
    }

    // Test validation when selected quantity is not numeric.
    public function test_dispatch_cannot_be_created_with_non_numeric_quantity()
    {
        $supplyItem = SupplyItem::factory()->create([
            'quantity' => 100,
        ]);

        Livewire::test(SelectedSupplyItemsList::class)
            ->set('selectedSupplyItems', [
                $supplyItem->id => $this->selectedSupplyItemData($supplyItem, 'abc'),
            ])
            ->call('save')
            ->assertHasErrors(['selectedSupplyItems.'.$supplyItem->id.'.quantity' => 'numeric']);

        $this->assertDatabaseCount('dispatches', 0);
    }

    private function selectedSupplyItemData(SupplyItem $supplyItem, mixed $quantity): array
    {
        return [
            'id' => $supplyItem->id,
            'supply_name' => $supplyItem->supply->name,
            'quantity' => $quantity,
        ];
    }
}
