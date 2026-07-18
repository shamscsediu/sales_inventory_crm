<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::resource('products', ProductController::class);
Route::resource('customers', App\Http\Controllers\CustomerController::class);
Route::resource('sales', App\Http\Controllers\SaleController::class);
Route::resource('branches', App\Http\Controllers\BranchController::class);
Route::put('branches/{branch}/inventory/{product}', [App\Http\Controllers\BranchController::class, 'updateInventory'])->name('branches.inventory.update');
