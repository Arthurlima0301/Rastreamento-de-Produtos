<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Clients\{ClientCreate, ClientEdit, ClientIndex};
use App\Livewire\Machines\{MachineCreate, MachineEdit, MachineIndex, MachineShow};
use App\Livewire\Supplies\{SupplyCreate, SupplyEdit, SupplyIndex, SupplyShow};
use App\Livewire\SupplyInvoices\{SupplyInvoiceIndex, SupplyInvoiceShow};
use App\Livewire\SupplyItems\{SupplyItemIndex};
use App\Livewire\Orders\{OrderCreate, OrderEdit, OrderIndex, OrderShow};
use App\Livewire\Materials\{MaterialCreate, MaterialEdit};
use App\Livewire\MaterialInvoices\{MaterialInvoiceIndex, MaterialInvoiceShow};
use App\Livewire\ItemMaterials\{ItemMaterialEdit, ItemMaterialIndex, ItemMaterialShow};
use App\Livewire\Rolls\{RollEdit, RollIndex, RollsCreate};
use App\Livewire\Loads\{LoadAddRolls, LoadCreate, LoadIndex, LoadShow};
use App\Livewire\Dispatches\{DispatchCreate, DispatchIndex, DispatchShow};
use App\Livewire\Pallets\PalletEdit;

// Client routes
Route::prefix('clients')->group(function () {
    Route::get('/', ClientIndex::class)->name('clients.index');
    Route::get('/create', ClientCreate::class)->name('clients.create');
    Route::get('/{client}/edit', ClientEdit::class)->name('clients.edit');
});

// Machine routes
Route::prefix('machines')->group(function () {
    Route::get('/', MachineIndex::class)->name('machines.index');
    Route::get('/create', MachineCreate::class)->name('machines.create');
    Route::get('/{machine}/edit', MachineEdit::class)->name('machines.edit');
    Route::get('/{machine}/show', MachineShow::class)->name('machines.show');
});

// Supply routes
Route::prefix('supplies')->group(function () {
    Route::get('/', SupplyIndex::class)->name('supplies.index');
    Route::get('/create', SupplyCreate::class)->name('supplies.create');
    Route::get('/{supply}', SupplyShow::class)->name('supplies.show');
    Route::get('/{supply}/edit', SupplyEdit::class)->name('supplies.edit');
});

// Supply invoice routes
Route::prefix('supply-invoices')->group(function () {
    Route::get('/', SupplyInvoiceIndex::class)->name('supply-invoices.index');
    Route::get('/{supplyInvoice}', SupplyInvoiceShow::class)->name('supply-invoices.show');
});

// Supply item routes
Route::prefix('supply-items')->group(function () {
    Route::get('/', SupplyItemIndex::class)->name('supply-items.index');
});

// Order routes
Route::prefix('orders')->group(function () {
    Route::get('/', OrderIndex::class)->name('orders.index');
    Route::get('/create', OrderCreate::class)->name('orders.create');
    Route::get('/{order}', OrderShow::class)->name('orders.show');
    Route::get('/{order}/edit', OrderEdit::class)->name('orders.edit');
    Route::get('/{order}/materials-create', MaterialCreate::class)->name('materials.create');
});

Route::get('material/{material}/edit', MaterialEdit::class)->name('materials.edit');


// Material invoice routes
Route::prefix('material-invoices')->group(function () {
    Route::get('/', MaterialInvoiceIndex::class)->name('material-invoices.index');
    Route::get('/{materialInvoice}', MaterialInvoiceShow::class)->name('material-invoices.show');
});

// Item material routes
Route::prefix('item-materials')->group(function () {
    Route::get('/', ItemMaterialIndex::class)->name('item-materials.index');
    Route::get('/{itemMaterial}', ItemMaterialShow::class)->name('item-materials.show');
    Route::get('/{itemMaterial}/edit', ItemMaterialEdit::class)->name('item-materials.edit');
    Route::get('/{itemMaterial}/roll-create', RollsCreate::class)->name('roll.create');
});

// Roll routes
Route::prefix('rolls')->group(function () {
    Route::get('/', RollIndex::class)->name('rolls.index');
    Route::get('/{roll}/edit', RollEdit::class)->name('rolls.edit');
});

// Pallet routes
Route::prefix('pallets')->group(function () {
    Route::get('/{pallet}/edit', PalletEdit::class)->name('pallets.edit');
});

// Load routes
Route::prefix('loads')->group(function () {
    Route::get('/', LoadIndex::class)->name('loads.index');
    Route::get('/create', LoadCreate::class)->name('loads.create');
    Route::get('/{load}', LoadShow::class)->name('loads.show');
    Route::get('/{load}/add-rolls', LoadAddRolls::class)->name('loads.add-rolls');
});

// Dispatch routes
Route::prefix('dispatches')->group(function () {
    Route::get('/', DispatchIndex::class)->name('dispatches.index');
    Route::get('/create', DispatchCreate::class)->name('dispatches.create');
    Route::get('/{dispatch}', DispatchShow::class)->name('dispatches.show');
});
