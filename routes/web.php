<?php
#eee

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProduitController;

Route::get('/', function () {
    return view('base');
});
// Route::get('/ventes', [App\Http\Controllers\VenteController::class, 'index'])->name('ventes.index');
// Route::get('/ventes/new', [App\Http\Controllers\VenteController::class, 'create'])->name('vente.create');
// Route::get('/ventes/store', [App\Http\Controllers\VenteController::class, 'create'])->name('ventes.store');

Route::prefix('admin')->name('admin.')->group(function (){
    Route::resource('produit', ProduitController::class)->except(['show']);
});
// Route::resource('produit', App\Http\Controllers\ProduitController::class)->except(['show']);
