<?php

namespace App\Http\Controllers\MaterialItems;

use App\Http\Controllers\Controller;

class MaterialItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.MaterialItems.index');
    }
}
