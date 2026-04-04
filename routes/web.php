<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InsumoController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\NotaFiscalController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('insumos', InsumoController::class);

Route::get('/notas', [NotaFiscalController::class, 'index'])->name('notas.index');
Route::post('notas/import', [NotaFiscalController::class, 'import'])->name('notas.import');

Route::get('/items', [ItemController::class, 'index'])->name('items.index');