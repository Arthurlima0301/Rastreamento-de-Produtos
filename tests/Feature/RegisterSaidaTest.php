<?php

namespace Tests\Feature;

use App\Models\Insumo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterSaidaTest extends TestCase
{


    use RefreshDatabase;

    /**
     * Test a register saida
     */
    public function test_cadastro_de_saida()
    {

        // criar um insumo, uma nota fiscal e um item com quantidade 100
        \App\Models\Insumo::create([
            'codigo_insumo' => '1',
            'nome' => 'Produto 1',
            'unidade_medida' => 'un',
        ]);

        \App\Models\NotaFiscal::create([
            'codigo_nf' => '445551',
            'data_emissao' => '2024-01-01',
        ]);

        \App\Models\Item::create([
            'numero' => '1',
            'nota_fiscal_id' => '1',
            'insumo_id' => '1',
            'quantidade' => '200',
        ]);


        // fazer post na rota de saidas passando os itens e as quantidades para consumir
        $this->post('saidas', [
            'items' => [
                0 => [
                    'id' => '1',
                    'quantidade' => '10',
                ],
                1 => [
                    'id' => '1',
                    'quantidade' => '10',
                ]
            ]
        ]);


        // verificar se a saida foi registrada
        $this->assertDatabaseHas('saidas_items', [
            'id' => '1',
            'quantidade' => '10',
        ]);

        $this->assertDatabaseHas('saidas_items', [
            'id' => '2',
            'quantidade' => '10',
        ]);
    }

    /**
     * Test register consume Item with exact balance  
     */
    public function test_atualiza_saldo_do_item()
    {
        // criar um insumo, uma nota fiscal e um item com quantidade 100
        \App\Models\Insumo::create([
            'codigo_insumo' => '1',
            'nome' => 'Produto 1',
            'unidade_medida' => 'un',
        ]);

        \App\Models\NotaFiscal::create([
            'codigo_nf' => '445551',
            'data_emissao' => '2024-01-01',
        ]);

        \App\Models\Item::create([
            'numero' => '1',
            'nota_fiscal_id' => '1',
            'insumo_id' => '1',
            'quantidade' => '100',
        ]);

        // fazer post na rota de saidas passando os itens e as quantidades para consumir
        $response = $this->post('saidas', [
            'items' => [
                0 => [
                    'id' => '1',
                    'quantidade' => '100',
                ]
            ]
        ]);

        // verificar se o saldo do item é zero
        $this->assertEquals(0, \App\Models\Item::withSum('saidasItems', 'quantidade')->find(1)->saldo);
    }


    /**
     * Test register consume Item with unsuficient balance  
     */
    public function test_nao_permite_consumir_item_com_saldo_insuficiente()
    {
        // criar um insumo, uma nota fiscal e um item com quantidade 100
        \App\Models\Insumo::create([
            'codigo_insumo' => '1',
            'nome' => 'Produto 1',
            'unidade_medida' => 'un',
        ]);

        \App\Models\NotaFiscal::create([
            'codigo_nf' => '445551',
            'data_emissao' => '2024-01-01',
        ]);

        \App\Models\Item::create([
            'numero' => '1',
            'nota_fiscal_id' => '1',
            'insumo_id' => '1',
            'quantidade' => '100',
        ]);


        // fazer post na rota de saidas passando os itens e as quantidades para consumir
        $response = $this->post('saidas', [
            'items' => [
                0 => [
                    'id' => '1',
                    'quantidade' => '101',
                ]
            ]
        ]);

        // verificar se a saida não foi registrada
        $this->assertDatabaseMissing('saidas', [
            'id' => '1',
        ]);

        $this->assertDatabaseMissing('saidas_items', [
            'id' => '1',
        ]);

        $response->assertSessionHas('error');
    }
}
