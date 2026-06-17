<?php

use App\Livewire\Supplies\SupplyForm;
use App\Models\Client;
use App\Models\Supply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SupplyUpdateTest extends TestCase
{
    use RefreshDatabase;

    // Test that the supply edit page can be rendered.
    public function test_supply_edit_page_can_be_rendered()
    {
        $supply = Supply::factory()->create([
            'supply_code' => 'SUP-100',
            'name' => 'Cola Hotmelt',
            'unit_of_measure' => 'kg',
        ]);

        $response = $this->get(route('supplies.edit', $supply));

        $response->assertStatus(200);
        $response->assertSee('Editar Insumo');
        $response->assertSee('SUP-100');
        $response->assertSee('Cola Hotmelt');
    }

    // Test that supply data can be updated.
    public function test_supply_can_be_updated()
    {
        $client = Client::factory()->create();

        $supply = Supply::factory()->create([
            'supply_code' => 'SUP-100',
            'name' => 'Cola Hotmelt',
            'unit_of_measure' => 'kg',
        ]);

        Livewire::test(SupplyForm::class, ['supplyId' => $supply->id])
            ->set('supply_code', 'SUP-101')
            ->set('name', 'Cola Hotmelt Atualizada')
            ->set('unit_of_measure', 'un')
            ->set('client_id', $client->id)
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('supplies.index'));

        $this->assertDatabaseHas('supplies', [
            'id' => $supply->id,
            'supply_code' => 'SUP-101',
            'name' => 'Cola Hotmelt Atualizada',
            'unit_of_measure' => 'un',
            'client_id' => $client->id,
        ]);
    }

    // Test that invalid updates do not change supply data.
    public function test_supply_cannot_be_updated_with_invalid_data()
    {
        $client = Client::factory()->create();

        Supply::factory()->create([
            'supply_code' => 'SUP-200',
        ]);

        $supply = Supply::factory()->create([
            'supply_code' => 'SUP-100',
            'name' => 'Cola Hotmelt',
            'unit_of_measure' => 'kg',
            'client_id' => $client->id,
        ]);

        Livewire::test(SupplyForm::class, ['supplyId' => $supply->id])
            ->set('supply_code', 'SUP-200')
            ->set('name', '')
            ->set('unit_of_measure', '')
            ->set('client_id', null)
            ->call('save')
            ->assertHasErrors(['supply_code', 'name', 'unit_of_measure', 'client_id']);

        $this->assertDatabaseHas('supplies', [
            'id' => $supply->id,
            'supply_code' => 'SUP-100',
            'name' => 'Cola Hotmelt',
            'unit_of_measure' => 'kg',
            'client_id' => $client->id,
        ]);
    }
}
