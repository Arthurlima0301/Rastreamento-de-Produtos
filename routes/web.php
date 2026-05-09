<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplyController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\DispatchController;


// Supply routes
Route::resource('supplies', SupplyController::class);

// Invoice routes
Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
Route::post('invoices/import', [InvoiceController::class, 'import'])->name('invoices.import');
Route::get('invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');

// Item routes
Route::get('/items', [ItemController::class, 'index'])->name('items.index');

// Dispatch routes
Route::get('/dispatches', [DispatchController::class, 'index'])->name('dispatches.index');
Route::get('/dispatches/create', [DispatchController::class, 'create'])->name('dispatches.create');
Route::post('/dispatches', [DispatchController::class, 'store'])->name('dispatches.store');
Route::get('/dispatches/{dispatch}', [DispatchController::class, 'show'])->name('dispatches.show');
