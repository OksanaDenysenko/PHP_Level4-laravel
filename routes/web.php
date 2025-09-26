<?php

use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('people')->name('people.')->group(function () {
    Route::get('/', [PersonController::class, 'index'])->name('index');
    Route::get('/create', [PersonController::class, 'create'])->name('create');
    Route::post('/', [PersonController::class, 'store'])->name('store');
    Route::put('/{person}', [PersonController::class, 'update'])->name('update');
    Route::delete('/{person}', [PersonController::class, 'destroy'])->name('destroy');
});
