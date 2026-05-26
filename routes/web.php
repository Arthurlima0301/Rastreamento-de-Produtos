<?php

use App\Http\Controllers\Clients\ClientController;
use App\Http\Controllers\Dispatches\DispatchController;
use App\Http\Controllers\Machines\MachineController;
use App\Http\Controllers\Orders\OrderController;
use App\Http\Controllers\Supplies\SupplyController;
use App\Http\Controllers\SupplyInvoices\SupplyInvoiceController;
use App\Http\Controllers\SupplyItems\SupplyItemController;
use App\Livewire\Dispatches\CreateDispatch;
use Illuminate\Support\Facades\Route;

// Client routes
Route::resource('clients', ClientController::class)->except(['show']);

// Machine routes
Route::resource('machines', MachineController::class);

// Supply routes
Route::resource('supplies', SupplyController::class);

// Supply invoice routes
Route::get('/supply-invoices', [SupplyInvoiceController::class, 'index'])->name('supply-invoices.index');
Route::post('supply-invoices/import', [SupplyInvoiceController::class, 'import'])->name('supply-invoices.import');
Route::get('supply-invoices/{supplyInvoice}', [SupplyInvoiceController::class, 'show'])->name('supply-invoices.show');

// Supply item routes
Route::get('/supply-items', [SupplyItemController::class, 'index'])->name('supply-items.index');

// Order routes
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

// Dispatch routes
Route::get('/dispatches', [DispatchController::class, 'index'])->name('dispatches.index');
Route::get('/dispatches/create', CreateDispatch::class)->name('dispatches.create');
Route::get('/dispatches/{dispatch}', [DispatchController::class, 'show'])->name('dispatches.show');
