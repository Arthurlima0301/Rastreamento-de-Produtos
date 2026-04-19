<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InsumoController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\NotaFiscalController;
use App\Http\Controllers\SaidaController;


// Insumo routes
Route::resource('insumos', InsumoController::class);

// Nota Fiscal routes
Route::get('/notas', [NotaFiscalController::class, 'index'])->name('notas.index');
Route::post('notas/import', [NotaFiscalController::class, 'import'])->name('notas.import');

// Item routes
Route::get('/items', [ItemController::class, 'index'])->name('items.index');

// Saida routes
Route::get('/saidas', [SaidaController::class, 'index'])->name('saidas.index');
Route::get('/saidas/create', [SaidaController::class, 'create'])->name('saidas.create');
Route::post('/saidas', [SaidaController::class, 'store'])->name('saidas.store');
Route::get('/saidas/{saida}', [SaidaController::class, 'show'])->name('saidas.show');

