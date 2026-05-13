<?php

namespace App\Http\Controllers\Supplies;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supplies\StoreSupplyRequest;
use App\Http\Requests\Supplies\UpdateSupplyRequest;
use App\Models\Supply;

class SupplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.Supplies.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.Supplies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplyRequest $request)
    {
        Supply::create($request->validated());

        return redirect()->route('supplies.index')->with('success', 'Insumo criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supply $supply)
    {
        return view('pages.Supplies.show', compact('supply'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supply $supply)
    {
        return view('pages.Supplies.edit', compact('supply'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplyRequest $request, Supply $supply)
    {
        $supply->update($request->validated());

        return redirect()->route('supplies.index')->with('success', 'Insumo atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supply $supply)
    {
        $supply->delete();

        return redirect()->route('supplies.index')->with('success', 'Insumo deletado com sucesso.');
    }
}
