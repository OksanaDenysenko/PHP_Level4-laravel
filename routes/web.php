<?php

use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/people', [PersonController::class,'index'])->name('people.index');
Route::get('/people/create', [PersonController::class,'create'])->name('people.create');
Route::post('/people/store', [PersonController::class,'store'])->name('people.store');
Route::put('/people/{person}', [PersonController::class,'update'])->name('people.update');
Route::delete('/people/{person}', [PersonController::class,'destroy'])->name('people.destroy');
