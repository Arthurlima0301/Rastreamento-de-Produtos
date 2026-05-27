<?php

use App\Livewire\Clients\ClientCreate;
use App\Livewire\Clients\ClientEdit;
use App\Livewire\Clients\ClientIndex;
use App\Livewire\Dispatches\DispatchCreate;
use App\Livewire\Dispatches\DispatchIndex;
use App\Livewire\Dispatches\DispatchShow;
use App\Livewire\Invoices\InvoiceIndex;
use App\Livewire\Invoices\InvoiceShow;
use App\Livewire\Items\ItemIndex;
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

// Invoice routes
Route::get('/invoices', InvoiceIndex::class)->name('invoices.index');
Route::get('invoices/{invoice}', InvoiceShow::class)->name('invoices.show');

// Item routes
Route::get('/items', ItemIndex::class)->name('items.index');

// Dispatch routes
Route::get('/dispatches', DispatchIndex::class)->name('dispatches.index');
Route::get('/dispatches/create', DispatchCreate::class)->name('dispatches.create');
Route::get('/dispatches/{dispatch}', DispatchShow::class)->name('dispatches.show');
