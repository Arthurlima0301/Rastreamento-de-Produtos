<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\Clients\ClientForm;
use App\Models\Client;

class ClientCreateTest extends TestCase
{
    use RefreshDatabase;

    // Test that the client creation page can be rendered
    public function test_client_page_can_be_rendered()
    {
        $response = $this->get(route('clients.create'));
        $response->assertStatus(200);
        $response->assertSee('Criar Cliente');
    }

    // Test that a client can be created successfully
    public function test_client_can_be_created()
    {
        Livewire::test(ClientForm::class)
            ->set('name', 'Empresa 1')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('clients', [
            'name' => 'Empresa 1'
        ]);
    }

    // Test that the user is redirected after successfully creating a client
    public function test_user_is_redirected_after_client_creation()
    {
        Livewire::test(ClientForm::class)
            ->set('name','Empresa 1')
            ->call('save')
            ->assertRedirect(route('clients.index'));
    }

    // Test that validation errors are shown when creating a client with invalid data
    public function test_client_creation_validation_errors()
    {
        Livewire::test(ClientForm::class)
            ->set('name', '')
            ->call('save')
            ->assertHasErrors(['name'=> 'required']);

        $this->assertDatabaseMissing('clients',
        [
            'name' => ''
        ]);
    }
}
