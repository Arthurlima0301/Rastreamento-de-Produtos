<?php

namespace App\Http\Controllers\SupplyInvoices;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplyInvoices\ImportXMLRequest;
use App\Models\SupplyInvoice;
use App\Services\SupplyInvoices\ImportSupplyInvoiceFromXMLService;

class SupplyInvoiceController extends Controller
{
    /**
     * Inject the ImportSupplyInvoiceFromXMLService into the controller.
     */
    public function __construct(
        private ImportSupplyInvoiceFromXMLService $importService
    ) {}

    /*
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.SupplyInvoices.index');
    }

    /*
     * Import a newly created resource in storage.
     */
    public function import(ImportXMLRequest $request)
    {
        try {
            $this->importService->import($request->file('xml_file'));

        } catch (\Exception $e) {
            return redirect()->route('supply-invoices.index')->with('error', 'Erro ao importar nota fiscal de insumo: '.$e->getMessage());

        }

        return redirect()->route('supply-invoices.index')->with('success', 'Nota fiscal de insumo importada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $supplyInvoice = SupplyInvoice::with('supplyItems', 'supplyItems.supply')
            ->withCount('supplyItems')
            ->findOrFail($id);

        return view('pages.SupplyInvoices.show', compact('supplyInvoice'));
    }
}
