<?php


namespace Tests\Feature\ItemMaterial;

use App\Livewire\Loads\SelectedRollsList;
use Tests\TestCase;
use Livewire\Livewire;
use App\Models\ItemMaterial;
use App\Models\Machine;
use App\Models\MaterialInvoice;
use App\Models\Roll;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemMaterialBalancesTest extends TestCase
{
    use RefreshDatabase;

    // Test if the formatted total weight is calculated correctly.
    public function test_material_invoice_show_can_be_rendered()
    {
        $materialInvoice = MaterialInvoice::factory()->create();

        $itemMaterial = ItemMaterial::factory()->create([
            'material_invoice_id' => $materialInvoice->id,
        ]);

        // Create rolls for the item material
        $roll = Roll::factory()->create([
            'item_material_id' => $itemMaterial->id,
            'weight' => 100,
            'status' => 'EM_ESTOQUE',
        ]);

        $roll2 = Roll::factory()->create([
            'item_material_id' => $itemMaterial->id,
            'weight' => 100,
            'status' => 'CORTADA',
        ]);

        $response = $this->get(route('material-invoices.show', $materialInvoice));
        $response->assertSee('Detalhes de Nota Fiscal de Material');
        $response->assertSee($itemMaterial->material->cutted_weight);
        $response->assertSee($itemMaterial->material->no_cutted_weight);
        $response->assertStatus(200);
    }


    // Test if roll cutted_weight and no_cutted_weight are updated correctly.
    public function test_item_material_roll_weights_are_updated_correctly()
    {
        $machine = Machine::factory()->create();

        $materialInvoice = MaterialInvoice::factory()->create();

        $itemMaterial = ItemMaterial::factory()->create([
            'material_invoice_id' => $materialInvoice->id,
        ]);

        // Create rolls for the item material
        $roll = Roll::factory()->create([
            'item_material_id' => $itemMaterial->id,
            'weight' => 100,
            'status' => 'EM_ESTOQUE',
        ]);

        $roll2 = Roll::factory()->create([
            'item_material_id' => $itemMaterial->id,
            'weight' => 100,
            'status' => 'EM_ESTOQUE',
        ]);

        Livewire::test(SelectedRollsList::class)
            ->call('addRoll', $roll->id, $roll->label, $roll->formatted_weight)
            ->set('selectedMachineId', $machine->id)
            ->set('selectedTurn', 'DIURNO')
            ->set('selectedCuttedAt', '2026-06-06')
            ->call('save')
            ->assertHasNoErrors();

        $itemMaterial = $itemMaterial->query()
            ->withCuttedRolls()
            ->withNoCuttedRolls()
            ->first();

        $this->assertEquals(100, $itemMaterial->cutted_weight);
        $this->assertEquals(100, $itemMaterial->no_cutted_weight);
    }
}   
