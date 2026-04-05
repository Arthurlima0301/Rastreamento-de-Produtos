<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use App\Http\Requests\StoreInsumoRequest;
use App\Http\Requests\UpdateInsumoRequest;
use Illuminate\Http\Request;

class InsumoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $insumos = Insumo::all();
        return view('insumos.index', compact('insumos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('insumos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInsumoRequest $request)
    {
        Insumo::create($request->validated());
        return redirect()->route('insumos.index')->with('success', 'Insumo criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Insumo $insumo)
    {
        return view('insumos.show', compact('insumo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Insumo $insumo)
    {
        return view('insumos.edit', compact('insumo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInsumoRequest $request, Insumo $insumo)
    {
        $insumo->update($request->validated());
        return redirect()->route('insumos.index')->with('success', 'Insumo atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Insumo $insumo)
    {
        $insumo->delete();
        return redirect()->route('insumos.index')->with('success', 'Insumo deletado com sucesso.');
    }
}
