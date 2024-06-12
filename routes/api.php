<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\BiereController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\CommandeController;


Route::get('bieres', [BiereController::class, 'index']);
Route::post('bieres', [BiereController::class, 'upload']);
Route::put('bieres/{biere}', [BiereController::class, 'update']);
Route::delete('bieres/{biere}', [BiereController::class, 'destroy']);

Route::get('stock', [StockController::class, 'index']);
Route::post('stock', [StockController::class, 'upload']);
Route::put('stock/{stock}', [StockController::class, 'update']);
Route::delete('stock/{stock}', [StockController::class, 'destroy']);


Route::post('commandes', [CommandeController::class, 'upload']);
Route::get('commandes/{id}', [CommandeController::class, 'index']);
Route::get('commandes', [CommandeController::class, 'indexAll']);
