<?php
#eee

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProduitController;
use App\Http\Controllers\Admin\JournalController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\VenteController;

$idRegex   = '[0-9]+';
$slugRegex = '[0-9a-z\-]+';


Route::get('/', function () {
    return view('base');
});
// Route::get('/ventes', [App\Http\Controllers\VenteController::class, 'index'])->name('ventes.index');
// Route::get('/ventes/new', [App\Http\Controllers\VenteController::class, 'create'])->name('vente.create');
// Route::get('/ventes/store', [App\Http\Controllers\VenteController::class, 'create'])->name('ventes.store');

Route::prefix('admin')->name('admin.')->group(function (){
    Route::resource('produit', ProduitController::class)->except(['show']);
    Route::resource('type', TypeController::class)->except(['show']);
    Route::resource('journal', JournalController::class);
});

// Route::delete('admin/produit/{image}', [ProduitController::class, 'destroyImage'])
//     ->name('admin.produit.destroyImage')
//     ->where([
//         'image' => $idRegex,
//     ]);
Route::get('produit/{id}', [ProduitController::class, 'destroyImage'])
    ->name('produit.destroyImage')
    ->where([
        'id' => $idRegex,
]);

Route::prefix('boutique')->name('boutique.')->group(function (){
    Route::resource('vente', VenteController::class);
});
