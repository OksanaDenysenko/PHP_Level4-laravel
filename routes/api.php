<?php

use App\Http\Controllers\Api\FilmController;
use App\Http\Controllers\Api\PlanetController;
use App\Http\Controllers\Api\SpeciesController;
use App\Http\Controllers\Api\StarshipController;
use App\Http\Controllers\Api\VehicleController;
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
        Route::post('/',  'store')->name('store');
        Route::put('/{person}',  'update')->name('update');
        Route::delete('/{person}', 'destroy')->name('destroy');
    });

//Route::prefix('lookups')
//    ->name('lookups.')
//    ->group(function () {
//        Route::get('/planets', [PlanetController::class, 'getLookups'])->name('planets');
//        Route::get('/films', [FilmController::class, 'getLookups'])->name('films');
//        Route::get('/species', [SpeciesController::class, 'getLookups'])->name('species');
//        Route::get('/starships', [StarshipController::class, 'getLookups'])->name('starships');
//        Route::get('/vehicles', [VehicleController::class, 'getLookups'])->name('vehicles');
//    });

Route::get('/planets', [PlanetController::class, 'getLookups'])->name('planets.lookups');
Route::get('/films', [FilmController::class, 'getLookups'])->name('films.lookups');
Route::get('/species', [SpeciesController::class, 'getLookups'])->name('species.lookups');
Route::get('/starships', [StarshipController::class, 'getLookups'])->name('starships.lookups');
Route::get('/vehicles', [VehicleController::class, 'getLookups'])->name('vehicles.lookups');
