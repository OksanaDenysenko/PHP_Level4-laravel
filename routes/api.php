<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PersonController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('people')
    ->name('people.')
    ->controller(PersonController::class)
    ->group(function () {
        Route::get('/person-form-options', 'getFormOptions')->name('getFormOptions');
        Route::post('/',  'store')->name('store');
        Route::put('/{person}',  'update')->name('update');
        Route::delete('/{person}', 'destroy')->name('destroy');
    });
