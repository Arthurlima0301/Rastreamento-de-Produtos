<?php

namespace App\Http\Controllers\MaterialInvoices;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaterialInvoices\ImportXMLRequest;
use App\Models\MaterialInvoice;
use App\Services\MaterialInvoices\ImportMaterialInvoiceFromXMLService;

class MaterialInvoiceController extends Controller
{
    /**
     * Inject the ImportMaterialInvoiceFromXMLService into the controller.
     */
    public function __construct(
        private ImportMaterialInvoiceFromXMLService $importService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.MaterialInvoices.index');
    }

    /*
     * Import a newly created resource in storage.
     */
    public function import(ImportXMLRequest $request)
    {
        try {
            $this->importService->import($request->file('xml_file'));

        } catch (\Exception $e) {
            return redirect()->route('material-invoices.index')->with('error', 'Erro ao importar nota fiscal de material: '.$e->getMessage());

        }

        return redirect()->route('material-invoices.index')->with('success', 'Nota fiscal de material importada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(MaterialInvoice $materialInvoice)
    {
        $materialInvoice->load('materialItems', 'materialItems.material', 'materialItems.material.order')
            ->loadCount('materialItems');

        return view('pages.MaterialInvoices.show', compact('materialInvoice'));
    }
}
