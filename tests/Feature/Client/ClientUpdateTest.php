<?php

use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Livewire\Clients\ClientForm;
use App\Models\Client;

class ClientUpdateTest extends TestCase
{
    use RefreshDatabase;

    // Test that the client edit page can be rendered
    public function test_client_edit_page_can_be_rendered() {
        $client1 = Client::factory()->create([
            'name' => 'Empresa 1'
        ]);

        $response = $this->get(route('clients.edit', $client1));
        $response->assertStatus(200);
        $response->assertSee('Editar Cliente');
        $response->assertSee('Empresa 1');
    }

    // Test that a client can be updated successfully
    public function test_client_can_be_updated()
    {
        $client1 = Client::factory()->create([
            'name' => 'Empresa 1'
        ]);

        Livewire::test(ClientForm::class)
        ->set('clientId',$client1->id)
        ->set('name','Empresa 1 Atualizada')
        ->call('save')
        ->assertHasNoErrors();

        $this->assertDatabaseHas('clients',[
            'name' => 'Empresa 1 Atualizada'
        ]);

        $this->assertDatabaseMissing('clients',[
            'name' => 'Empresa 1'
        ]);
    }

    // Test if user is redirected after client update
    public function test_user_is_redirected_after_client_update()
    {
        $client1 = Client::factory()->create([
            'name' => 'Empresa 1'
        ]);

        Livewire::test(ClientForm::class)
        ->set('clientId',$client1->id)
        ->set('name','Empresa 1 Atualizada')
        ->call('save')
        ->assertRedirect(route('clients.index'));

    }

    // Test that a client cannot be updated with invalid data
    public function test_client_cannot_be_updated_with_invalid_data()
    {
        $client1 = Client::factory()->create([
            'name' => 'Empresa 1'
        ]);

        Livewire::test(ClientForm::class)
        ->set('clientId',$client1->id)
        ->set('name','')
        ->call('save')
        ->assertHasErrors(['name' => 'required']);

        $this->assertDatabaseMissing('clients',[
            'name' => 'Empresa 1 Atualizada'
        ]);

        $this->assertDatabaseHas('clients',[
            'name' => 'Empresa 1'
        ]);
    }
}
