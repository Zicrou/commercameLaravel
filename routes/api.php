<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Group for API v1
Route::prefix('V1')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/produits/supeAZero', [\App\Http\Controllers\V1\ProduitController::class, 'supeAZero']);
        Route::apiResource('produits', \App\Http\Controllers\V1\ProduitController::class);
        Route::apiResource('ventes', \App\Http\Controllers\V1\VenteController::class);
        Route::apiResource('types', \App\Http\Controllers\V1\TypeController::class);
        Route::apiResource('depenses', \App\Http\Controllers\V1\DepenseController::class);
    });
    Route::apiResource('journal', \App\Http\Controllers\V1\JournalController::class)->middleware('auth:sanctum');
    Route::post('/register', [\App\Http\Controllers\V1\AuthController::class, 'register']);
    Route::post('/login', [\App\Http\Controllers\V1\AuthController::class, 'login']);
    Route::post('/logout', [\App\Http\Controllers\V1\AuthController::class, 'logout'])->middleware('auth:sanctum');
});




// Route::apiResource('ventes', \App\Http\Controllers\VenteController::class);

// Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);

// Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);

// Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth:sanctum');
    