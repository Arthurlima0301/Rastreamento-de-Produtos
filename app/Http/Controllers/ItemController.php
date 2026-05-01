<?php

namespace App\Http\Controllers;

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
