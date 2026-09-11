<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\IncomingTransactionController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\OutgoingTransactionController;
use App\Http\Controllers\DepartmentController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource(
    'incoming-transactions',
    IncomingTransactionController::class
);

Route::resource('items', ItemController::class);
Route::resource('categories', CategoryController::class);
Route::resource('units', UnitController::class);
Route::resource('warehouses', WarehouseController::class);
Route::resource('suppliers', SupplierController::class);
Route::resource(
    'outgoing-transactions',
    OutgoingTransactionController::class
);
Route::resource('departments', DepartmentController::class);