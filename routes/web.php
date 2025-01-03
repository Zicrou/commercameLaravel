<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('base');
});
Route::get('/ventes', [App\Http\Controllers\VenteController::class, 'index'])->name('ventes.index');
