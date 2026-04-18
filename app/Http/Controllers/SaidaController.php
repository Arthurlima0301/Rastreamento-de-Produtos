<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Saida;


class SaidaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $saidas = Saida::orderBy('data_saida', 'desc')->get();
        return view('Saidas.index', compact('saidas'));
    }
}
