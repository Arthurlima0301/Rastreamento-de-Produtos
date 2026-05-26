<?php

namespace App\Http\Controllers\Dispatches;

use App\Http\Controllers\Controller;
use App\Models\Dispatch;

class DispatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.Dispatches.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dispatch $dispatch)
    {
        $dispatch = Dispatch::with('items.supplyItem.supply', 'items.supplyItem.supplyInvoice')->find($dispatch->id);

        return view('pages.Dispatches.show', compact('dispatch'));
    }
}
