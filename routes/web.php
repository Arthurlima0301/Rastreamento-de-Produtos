<?php

use App\Http\Controllers\Clients\ClientController;
use App\Http\Controllers\Dispatches\DispatchController;
use App\Http\Controllers\Invoices\InvoiceController;
use App\Http\Controllers\Items\ItemController;
use App\Http\Controllers\Orders\OrderController;
use App\Http\Controllers\Supplies\SupplyController;
use App\Livewire\Dispatches\CreateDispatch;
use Illuminate\Support\Facades\Route;

// Client routes
Route::resource('clients', ClientController::class)->except(['show']);

// Supply routes
Route::resource('supplies', SupplyController::class);

// Invoice routes
Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
Route::post('invoices/import', [InvoiceController::class, 'import'])->name('invoices.import');
Route::get('invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');

// Item routes
Route::get('/items', [ItemController::class, 'index'])->name('items.index');

// Order routes
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

// Dispatch routes
Route::get('/dispatches', [DispatchController::class, 'index'])->name('dispatches.index');
Route::get('/dispatches/create', CreateDispatch::class)->name('dispatches.create');
Route::get('/dispatches/{dispatch}', [DispatchController::class, 'show'])->name('dispatches.show');
