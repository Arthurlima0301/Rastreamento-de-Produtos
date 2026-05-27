<?php

use App\Http\Controllers\Dispatches\DispatchController;
use App\Http\Controllers\Invoices\InvoiceController;
use App\Http\Controllers\Items\ItemController;
use App\Http\Controllers\Supplies\SupplyController;
use App\Livewire\Clients\ClientCreate;
use App\Livewire\Clients\ClientEdit;
use App\Livewire\Clients\ClientIndex;
use App\Livewire\Dispatches\CreateDispatch;
use Illuminate\Support\Facades\Route;

// Client routes
Route::get('/clients', ClientIndex::class)->name('clients.index');
Route::get('/clients/create', ClientCreate::class)->name('clients.create');
Route::get('/clients/{client}/edit', ClientEdit::class)->name('clients.edit');

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
Route::get('/dispatches/create', CreateDispatch::class)->name('dispatches.create');
Route::get('/dispatches/{dispatch}', [DispatchController::class, 'show'])->name('dispatches.show');
