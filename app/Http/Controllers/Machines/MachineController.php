<?php

namespace App\Http\Controllers\Machines;

use App\Http\Controllers\Controller;
use App\Http\Requests\Machines\StoreMachineRequest;
use App\Http\Requests\Machines\UpdateMachineRequest;
use App\Models\Machine;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.Machines.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.Machines.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMachineRequest $request)
    {
        Machine::create($request->validated());

        return redirect()->route('machines.index')->with('success', 'Maquina criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Machine $machine)
    {
        return view('pages.Machines.show', compact('machine'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Machine $machine)
    {
        return view('pages.Machines.edit', compact('machine'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMachineRequest $request, Machine $machine)
    {
        $machine->update($request->validated());

        return redirect()->route('machines.index')->with('success', 'Maquina atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Machine $machine)
    {
        $machine->delete();

        return redirect()->route('machines.index')->with('success', 'Maquina deletada com sucesso.');
    }
}
