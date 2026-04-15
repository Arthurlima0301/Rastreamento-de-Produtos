<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::with('notaFiscal', 'insumo')->withSum('saidasItems', 'quantidade')->get();
        

        return view('items.index', compact('items'));
    }

    /**
     * 
     */


}
