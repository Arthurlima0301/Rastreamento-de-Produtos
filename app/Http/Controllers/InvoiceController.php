<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportXMLRequest;
use App\Models\Invoice;
use App\Services\ImportXMLData;

class InvoiceController extends Controller
{

    private $importService;

    public function __construct(ImportXMLData $importService)
    {
        $this->importService = $importService;
    }

    /*
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::orderBy('issued_at', 'desc')->get();
        return view('Invoices.index', compact('invoices'));
    }

    /*
     * Import a newly created resource in storage.
     */
    public function import(ImportXMLRequest $request)
    {
        try {
            $this->importService->import($request->file('xml_file'));

        } catch (\Exception $e) {
            return redirect()->route('invoices.index')->with('error', 'Erro ao importar nota fiscal: ' . $e->getMessage());

        }

        return redirect()->route('invoices.index')->with('success', 'Nota fiscal importada com sucesso!');
    }
}
