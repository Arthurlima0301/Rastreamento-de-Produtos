<?php

namespace App\Http\Controllers\Dispatches;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dispatches\ConsumeItemsRequest;
use App\Models\Dispatch;
use App\Models\Item;
use App\Services\Dispatches\ConsumeItemsService;

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
        return view('pages.Dispatches.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.Dispatches.create');
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
        return view('pages.Dispatches.show', compact('dispatch'));
    }
}
