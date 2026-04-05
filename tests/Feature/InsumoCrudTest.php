<?php

namespace Tests\Feature;

use App\Models\Insumo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InsumoCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_cria_insumo_com_dados_validos()
    {
        $response = $this->post('/insumos', [
            'codigo_insumo' => 'ABC123',
            'nome' => 'Teste',
            'unidade_medida' => 'kg',
        ]);
        $response->assertStatus(302); // Redireciona após sucesso
        $this->assertDatabaseHas('insumos', ['codigo_insumo' => 'ABC123']);
    }

    public function test_nao_cria_insumo_com_dados_invalidos()
    {
        $response = $this->post('/insumos', [
            'codigo_insumo' => '',
            'nome' => '',
            'unidade_medida' => '',
        ]);
        $response->assertSessionHasErrors(['codigo_insumo', 'nome', 'unidade_medida']);
    }

    public function test_lista_insumos()
    {
        Insumo::create([
            'codigo_insumo' => 'LISTA1',
            'nome' => 'Teste Lista',
            'unidade_medida' => 'kg',
        ]);
        $response = $this->get('/insumos');
        $response->assertStatus(200);
        $response->assertSee('LISTA1');
    }

    public function test_atualiza_insumo()
    {
        $insumo = Insumo::create([
            'codigo_insumo' => 'UPD1',
            'nome' => 'Antigo',
            'unidade_medida' => 'kg',
        ]);

        $response = $this->put("/insumos/{$insumo->id}", [
            'codigo_insumo' => 'UPD1',
            'nome' => 'Novo',
            'unidade_medida' => 'kg',
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('insumos', ['id' => $insumo->id, 'nome' => 'Novo']);
    }

    public function test_deleta_insumo()
    {
        $insumo = Insumo::create([
            'codigo_insumo' => 'DEL1',
            'nome' => 'Teste Deleta',
            'unidade_medida' => 'kg',
        ]);
        $response = $this->delete("/insumos/{$insumo->id}");
        $response->assertStatus(302);
        $this->assertDatabaseMissing('insumos', ['id' => $insumo->id]);
    }
}
