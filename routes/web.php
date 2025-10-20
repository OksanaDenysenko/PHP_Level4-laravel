<?php

use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('people')
    ->name('people.')
    ->controller(PersonController::class)
    ->group(function () {
    Route::get('/',  'index')->name('index');
    Route::get('/create',  'create')->name('create');
    Route::post('/',  'store')->name('store');
    Route::put('/{person}',  'update')->name('update');
    Route::delete('/{person}', 'destroy')->name('destroy');
});
