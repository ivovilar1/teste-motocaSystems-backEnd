<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Category;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// region Category
Route::post('category', Category\StoreController::class)->name('category.store');
Route::get('category', Category\IndexController::class)->name('category.index');
Route::get('category/{category}', Category\EditController::class)->name('category.edit');
Route::put('category/{category}', Category\UpdateController::class)->name('category.update');
// endregion
