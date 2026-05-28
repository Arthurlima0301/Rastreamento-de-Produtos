<?php

use App\Livewire\Clients\ClientCreate;
use App\Livewire\Clients\ClientEdit;
use App\Livewire\Clients\ClientIndex;
use App\Livewire\Dispatches\DispatchCreate;
use App\Livewire\Dispatches\DispatchIndex;
use App\Livewire\Dispatches\DispatchShow;
use App\Livewire\SupplyInvoices\SupplyInvoiceIndex;
use App\Livewire\SupplyInvoices\SupplyInvoiceShow;
use App\Livewire\SupplyItems\SupplyItemIndex;
use App\Livewire\Supplies\SupplyCreate;
use App\Livewire\Supplies\SupplyEdit;
use App\Livewire\Supplies\SupplyIndex;
use App\Livewire\Supplies\SupplyShow;
use Illuminate\Support\Facades\Route;

// Client routes
Route::get('/clients', ClientIndex::class)->name('clients.index');
Route::get('/clients/create', ClientCreate::class)->name('clients.create');
Route::get('/clients/{client}/edit', ClientEdit::class)->name('clients.edit');

// Supply routes
Route::get('/supplies', SupplyIndex::class)->name('supplies.index');
Route::get('/supplies/create', SupplyCreate::class)->name('supplies.create');
Route::get('/supplies/{supply}', SupplyShow::class)->name('supplies.show');
Route::get('/supplies/{supply}/edit', SupplyEdit::class)->name('supplies.edit');

// Supply invoice routes
Route::get('/supply-invoices', SupplyInvoiceIndex::class)->name('supply-invoices.index');
Route::get('supply-invoices/{supplyInvoice}', SupplyInvoiceShow::class)->name('supply-invoices.show');

// Supply item routes
Route::get('/supply-items', SupplyItemIndex::class)->name('supply-items.index');

// Dispatch routes
Route::get('/dispatches', DispatchIndex::class)->name('dispatches.index');
Route::get('/dispatches/create', DispatchCreate::class)->name('dispatches.create');
Route::get('/dispatches/{dispatch}', DispatchShow::class)->name('dispatches.show');
