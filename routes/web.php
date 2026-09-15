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
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

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
Route::get(
    '/reports/stock',
    [ReportController::class, 'stock']
)->name('reports.stock');