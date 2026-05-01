<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportXMLRequest;
use App\Services\ImportInvoiceFromXMLService;

class InvoiceController extends Controller
{
    /**
     * Inject the ImportInvoiceFromXMLService into the controller.
     */
    public function __construct(
        private ImportInvoiceFromXMLService $importService
    ) {}

    /*
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.Invoices.index');
    }

    /*
     * Import a newly created resource in storage.
     */
    public function import(ImportXMLRequest $request)
    {
        try {
            $this->importService->import($request->file('xml_file'));

        } catch (\Exception $e) {
            return redirect()->route('invoices.index')->with('error', 'Erro ao importar nota fiscal: '.$e->getMessage());

        }

        return redirect()->route('invoices.index')->with('success', 'Nota fiscal importada com sucesso!');
    }
}
