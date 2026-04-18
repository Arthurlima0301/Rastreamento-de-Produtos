<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Saida;

use App\Http\Requests\ConsumeItemsRequest;
use App\Services\ConsumeItemsService;


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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::with('notaFiscal', 'insumo')->withSum('saidasItems', 'quantidade')->get();
        return view('Saidas.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ConsumeItemsRequest $request) 
    {
        
        try {

            (new ConsumeItemsService())->consume($request->items);

            return redirect()->route('saidas.index')->with('success', 'Saída processada com sucesso!');
            
        }catch (\Exception $e) {
            
            return redirect()->back()->with('error', 'Ocorreu um erro ao processar a saída: ' . $e->getMessage());
        }
    }
}
