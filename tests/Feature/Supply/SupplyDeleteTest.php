<?php

use App\Livewire\Supplies\SupplyTable;
use App\Models\Supply;
use App\Models\SupplyItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SupplyDeleteTest extends TestCase
{
    use RefreshDatabase;

    // Test that the supply index page can be rendered before deleting.
    public function test_supply_index_page_can_be_rendered()
    {
        $response = $this->get(route('supplies.index'));

        $response->assertStatus(200);
        $response->assertSee('supplies.supply-table');
    }

    // Test that a supply without supply items can be deleted.
    public function test_supply_can_be_deleted()
    {
        $supply = Supply::factory()->create([
            'supply_code' => 'SUP-100',
        ]);

        Livewire::test(SupplyTable::class)
            ->call('destroy', $supply)
            ->assertRedirect(route('supplies.index'));

        $this->assertDatabaseMissing('supplies', [
            'id' => $supply->id,
        ]);
    }

    // Test that a supply linked to a supply item cannot be deleted.
    public function test_supply_cannot_be_deleted_when_it_has_supply_items()
    {
        $supply = Supply::factory()->create([
            'supply_code' => 'SUP-200',
        ]);

        SupplyItem::factory()->create([
            'supply_id' => $supply->id,
        ]);

        Livewire::test(SupplyTable::class)
            ->call('destroy', $supply)
            ->assertRedirect(route('supplies.index'));

        $this->assertDatabaseHas('supplies', [
            'id' => $supply->id,
        ]);
    }
}
