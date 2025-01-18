<?php
#eee

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProduitController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\VenteController;

Route::get('/', function () {
    return view('base');
});
// Route::get('/ventes', [App\Http\Controllers\VenteController::class, 'index'])->name('ventes.index');
// Route::get('/ventes/new', [App\Http\Controllers\VenteController::class, 'create'])->name('vente.create');
// Route::get('/ventes/store', [App\Http\Controllers\VenteController::class, 'create'])->name('ventes.store');

Route::prefix('admin')->name('admin.')->group(function (){
    Route::resource('produit', ProduitController::class)->except(['show']);
    Route::resource('type', TypeController::class)->except(['show']);
});

Route::prefix('boutique')->name('boutique.')->group(function (){
    Route::resource('vente', VenteController::class);
});
