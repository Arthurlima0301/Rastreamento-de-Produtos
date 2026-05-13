<?php

namespace App\Http\Controllers\Items;

use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.Items.index');
    }
}
