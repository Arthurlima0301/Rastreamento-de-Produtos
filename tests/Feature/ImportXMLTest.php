<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImportXMLTest extends TestCase
{
    use RefreshDatabase;
    /*
    * Test a valid XML import
    */
    public function test_importa_xml_valido()
    {
        // Register necessary products before import
        \App\Models\Insumo::create(['codigo_insumo' => '1001', 'nome' => 'Produto Genérico 1', 'unidade_medida' => 'UN']);
        \App\Models\Insumo::create(['codigo_insumo' => '1002', 'nome' => 'Produto Genérico 2', 'unidade_medida' => 'UN']);

        // Simulate the upload of a valid XML file
        $response = $this->post('notas/import', [
            'xml_file' => new \Illuminate\Http\UploadedFile(
                base_path('tests/Fixtures/nota_fiscal_valida.xml'),
                'nota_fiscal_valida.xml',
                'text/xml',
                null,
                true
            ),
        ]);

        $response->assertRedirect(route('notas.index'));
        $response->assertSessionHas('success');
    }


    /*
    * Test an invalid XML import
    */
    public function test_nao_importa_xml_invalido()
    {
        // Simulate the upload of an invalid XML file
        $response = $this->post('notas/import', [
            'xml_file' => new \Illuminate\Http\UploadedFile(
                base_path('tests/Fixtures/nota_fiscal_invalida.xml'),
                'nota_fiscal_invalida.xml',
                'text/xml',
                null,
                true
            ),
        ]);

        $response->assertRedirect(route('notas.index'));
        $response->assertSessionHas('error');
    }

    /**
     * Test that duplicate fiscal notes are not imported
     */
    public function test_nao_importa_nota_fiscal_duplicada()
    {
        // Simulate the upload of a valid XML file
        $this->post('notas/import', [
            'xml_file' => new \Illuminate\Http\UploadedFile(
                base_path('tests/Fixtures/nota_fiscal_valida.xml'),
                'nota_fiscal_valida.xml',
                'text/xml',
                null,
                true
            ),
        ]);

        // Try to import the same file again
        $response = $this->post('notas/import', [
            'xml_file' => new \Illuminate\Http\UploadedFile(
                base_path('tests/Fixtures/nota_fiscal_valida.xml'),
                'nota_fiscal_valida.xml',
                'text/xml',
                null,
                true
            ),
        ]);

        $response->assertRedirect(route('notas.index'));
        $response->assertSessionHas('error');
    }


    /**
     * Test that XML is not imported if the product code of the item is not registered
     */
    public function test_nao_importa_xml_se_codigo_produto_nao_cadastrado()
    {
        // Do not register products in the database
        $response = $this->post('notas/import', [
            'xml_file' => new \Illuminate\Http\UploadedFile(
                base_path('tests/Fixtures/nota_fiscal_valida.xml'),
                'nota_fiscal_valida.xml',
                'text/xml',
                null,
                true
            ),
        ]);
        $response->assertRedirect(route('notas.index'));
        $response->assertSessionHas('error');
    }

}
