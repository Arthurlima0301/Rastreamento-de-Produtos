<?php

use App\Livewire\Clients\ClientCreate;
use App\Livewire\Clients\ClientEdit;
use App\Livewire\Clients\ClientIndex;
use App\Livewire\Dispatches\DispatchCreate;
use App\Livewire\Dispatches\DispatchIndex;
use App\Livewire\Dispatches\DispatchShow;
use App\Livewire\ItemMaterials\ItemMaterialIndex;
use App\Livewire\ItemMaterials\ItemMaterialShow;
use App\Livewire\Rolls\RollsCreate;
use App\Livewire\Rolls\RollIndex;
use App\Livewire\MaterialInvoices\MaterialInvoiceIndex;
use App\Livewire\MaterialInvoices\MaterialInvoiceShow;
use App\Livewire\Materials\MaterialCreate;
use App\Livewire\Orders\OrderCreate;
use App\Livewire\Orders\OrderEdit;
use App\Livewire\Orders\OrderIndex;
use App\Livewire\Orders\OrderShow;
use App\Livewire\Supplies\SupplyCreate;
use App\Livewire\Supplies\SupplyEdit;
use App\Livewire\Supplies\SupplyIndex;
use App\Livewire\Supplies\SupplyShow;
use App\Livewire\SupplyInvoices\SupplyInvoiceIndex;
use App\Livewire\SupplyInvoices\SupplyInvoiceShow;
use App\Livewire\SupplyItems\SupplyItemIndex;
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

// Material invoice routes
Route::get('/material-invoices', MaterialInvoiceIndex::class)->name('material-invoices.index');
Route::get('/material-invoices/{materialInvoice}', MaterialInvoiceShow::class)->name('material-invoices.show');

// Item material routes
Route::get('/item-materials', ItemMaterialIndex::class)->name('item-materials.index');
Route::get('/item-materials/{itemMaterial}', ItemMaterialShow::class)->name('item-materials.show');
Route::get('/item-materials/{itemMaterial}/roll-create', RollsCreate::class)->name('roll.create');


// Order routes
Route::get('/orders', OrderIndex::class)->name('orders.index');
Route::get('/orders/create', OrderCreate::class)->name('orders.create');
Route::get('/orders/{order}', OrderShow::class)->name('orders.show');
Route::get('/orders/{order}/edit', OrderEdit::class)->name('orders.edit');
Route::get('/orders/{order}/materials-create', MaterialCreate::class)->name('materials.create');

// Rolls Routes
Route::get('/rolls', RollIndex::class)->name('rolls.index');

// Dispatch routes
Route::get('/dispatches', DispatchIndex::class)->name('dispatches.index');
Route::get('/dispatches/create', DispatchCreate::class)->name('dispatches.create');
Route::get('/dispatches/{dispatch}', DispatchShow::class)->name('dispatches.show');
