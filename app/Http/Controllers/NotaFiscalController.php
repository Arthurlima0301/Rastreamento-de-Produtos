<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotaFiscalImportRequest;
use App\Models\NotaFiscal;
use App\Services\ImportXMLData;

class NotaFiscalController extends Controller
{
    /*
     * Display a listing of the resource.
     */
    public function index()
    {
        $notas = NotaFiscal::orderBy('data_emissao', 'desc')->get();
        return view('NotaFiscal.index', compact('notas'));
    }

    /*
     * Import a newly created resource in storage.
     */
    public function import(NotaFiscalImportRequest $request)
    {
        try {
            (new ImportXMLData())->import($request->file('xml_file'));
        } catch (\Exception $e) {
            return redirect()->route('notas.index')->with('error', 'Erro ao importar nota fiscal: ' . $e->getMessage());
        }
        
        return redirect()->route('notas.index')->with('success', 'Nota fiscal importada com sucesso!');
    }
}
