<?php

namespace App\Http\Controllers;

use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::with('invoice', 'supply')->withSum('dispatchItems', 'quantity')->get();
        

        return view('Items.index', compact('items'));
    }

    /**
     * 
     */


}
