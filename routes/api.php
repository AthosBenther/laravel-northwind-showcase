<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resources([
    'customers' => CustomerController::class,
    'categories' => \App\Http\Controllers\CategoryController::class,
    'employees' => \App\Http\Controllers\EmployeeController::class,
    'order-details' => \App\Http\Controllers\OrderDetailController::class,
    'products' => \App\Http\Controllers\ProductController::class,
    'shippers' => \App\Http\Controllers\ShipperController::class,
    'suppliers' => \App\Http\Controllers\SupplierController::class,
    'territories' => \App\Http\Controllers\TerritoryController::class,
]);
