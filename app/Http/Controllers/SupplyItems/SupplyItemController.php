<?php

namespace App\Http\Controllers\SupplyItems;

use App\Http\Controllers\Controller;

class SupplyItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.SupplyItems.index');
    }
}
