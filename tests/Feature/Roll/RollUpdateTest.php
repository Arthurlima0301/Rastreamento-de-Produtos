<?php

use App\Livewire\Rolls\RollEdit;
use App\Models\Roll;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class RollUpdateTest extends TestCase
{
    use RefreshDatabase;

    // Test that the roll edit page can be rendered with existing data.
    public function test_roll_edit_page_can_be_rendered()
    {
        $roll = Roll::factory()->create([
            'label' => '007202026-0001',
            'weight' => 150,
        ]);

        $response = $this->get(route('rolls.edit', $roll));

        $response->assertStatus(200);
        $response->assertSee('Editar Bobina');
        $response->assertSee('007202026-0001');
        $response->assertSee('150');
    }

    // Test that roll data can be updated.
    public function test_roll_can_be_updated()
    {
        $roll = Roll::factory()->create([
            'label' => '007202026-0001',
            'weight' => 150,
            'defect' => null,
            'defect_weight' => null,
        ]);

        Livewire::test(RollEdit::class, ['roll' => $roll])
            ->set('rollLabel', '007202026-0009')
            ->set('rollWeight', 180)
            ->set('roll_defect', 'Rasgo')
            ->set('roll_defect_weight', 20)
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('item-materials.show', $roll->item_material_id));

        $this->assertDatabaseHas('rolls', [
            'id' => $roll->id,
            'label' => '007202026-0009',
            'weight' => 180,
            'defect' => 'Rasgo',
            'defect_weight' => 20,
        ]);
    }

    // Test that invalid roll updates are rejected.
    public function test_roll_cannot_be_updated_with_invalid_data()
    {
        Roll::factory()->create([
            'label' => '007202026-0008',
        ]);

        $roll = Roll::factory()->create([
            'label' => '007202026-0001',
            'weight' => 150,
        ]);

        Livewire::test(RollEdit::class, ['roll' => $roll])
            ->set('rollLabel', '007202026-0008')
            ->set('rollWeight', 99)
            ->call('save')
            ->assertHasErrors([
                'rollLabel' => 'unique',
                'rollWeight' => 'min',
            ]);

        $this->assertDatabaseHas('rolls', [
            'id' => $roll->id,
            'label' => '007202026-0001',
            'weight' => 150,
        ]);
    }
}
