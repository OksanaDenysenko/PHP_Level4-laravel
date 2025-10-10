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
    Route::get('/{person}',  'show')->name('show');
});
