<?php

use App\Livewire\Supplies\SupplyForm;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SupplyCreateTest extends TestCase
{
    use RefreshDatabase;

    // Test that the supply creation page and form component can be rendered.
    public function test_supply_create_page_can_be_rendered()
    {
        $response = $this->get(route('supplies.create'));

        $response->assertStatus(200);
        $response->assertSee('Criar Insumo');
        $response->assertSee('supplies.supply-form');
    }

    // Test that a supply can be created with valid data.
    public function test_supply_can_be_created_with_valid_data()
    {
        $client = Client::factory()->create([
            'name' => 'Empresa 1',
        ]);

        Livewire::test(SupplyForm::class)
            ->set('supply_code', 'SUP-100')
            ->set('name', 'Cola Hotmelt')
            ->set('unit_of_measure', 'kg')
            ->set('client_id', $client->id)
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('supplies.index'));

        $this->assertDatabaseHas('supplies', [
            'supply_code' => 'SUP-100',
            'name' => 'Cola Hotmelt',
            'unit_of_measure' => 'kg',
            'client_id' => $client->id,
        ]);
    }

    // Test that a supply is not created with invalid data.
    public function test_supply_cannot_be_created_with_invalid_data()
    {
        Livewire::test(SupplyForm::class)
            ->set('supply_code', '')
            ->set('name', '')
            ->set('unit_of_measure', '')
            ->set('client_id', null)
            ->call('save')
            ->assertHasErrors(['supply_code', 'name', 'unit_of_measure', 'client_id']);

        $this->assertDatabaseCount('supplies', 0);
    }
}
