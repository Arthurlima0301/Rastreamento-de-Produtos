<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConsumeItemsRequest;
use App\Models\Dispatch;
use App\Models\Item;
use App\Services\ConsumeItemsService;

class DispatchController extends Controller
{
    /**
     * Inject the ConsumeItemsService into the controller.
     */
    public function __construct(
        private ConsumeItemsService $consumeItemsService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dispatches = Dispatch::orderBy('dispatched_at', 'desc')->get();
        return view('Dispatches.index', compact('dispatches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::with('invoice', 'supply')->withSum('dispatchItems', 'quantity')->get();
        return view('Dispatches.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ConsumeItemsRequest $request)
    {
        try {
            $this->consumeItemsService->consume($request->validated()['items']);

            return redirect()->route('dispatches.index')->with('success', 'Saída processada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao processar a saída: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Dispatch $dispatch)
    {
        $dispatch = Dispatch::with('items.item.supply', 'items.item.invoice')->find($dispatch->id);
        return view('Dispatches.show', compact('dispatch'));
    }
}
