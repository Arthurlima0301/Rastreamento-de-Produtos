<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InsumoController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('insumos', InsumoController::class);
