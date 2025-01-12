<?php
#eee
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('base');
});
Route::get('/ventes', [App\Http\Controllers\VenteController::class, 'index'])->name('ventes.index');
Route::get('/ventes/new', [App\Http\Controllers\VenteController::class, 'create'])->name('vente.create');
Route::get('/ventes/store', [App\Http\Controllers\VenteController::class, 'create'])->name('ventes.store');
