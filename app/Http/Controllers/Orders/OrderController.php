<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.Orders.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('client', 'materials')
            ->loadCount('materials');

        return view('pages.Orders.show', compact('order'));
    }
}
