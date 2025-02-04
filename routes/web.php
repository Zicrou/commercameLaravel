<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\ProduitController;
use App\Http\Controllers\Admin\JournalController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\DepenseController;
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

Route::prefix('depense')->name('depense.')->group(function (){
    Route::resource('depense', DepenseController::class);
});

Route::prefix('boutique')->name('boutique.')->group(function (){
    Route::resource('vente', VenteController::class);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
