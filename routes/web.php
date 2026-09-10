<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\WarehouseController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('items', ItemController::class);
Route::resource('categories', CategoryController::class);
Route::resource('units', UnitController::class);
Route::resource('warehouses', WarehouseController::class);