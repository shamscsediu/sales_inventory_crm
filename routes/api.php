<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', function () {
    return response()->json(\App\Models\Product::all());
});

Route::get('/customers', function () {
    return response()->json(\App\Models\Customer::with('employee')->get());
});

Route::get('/sales/{sale}', function (\App\Models\Sale $sale) {
    return response()->json($sale->load(['customer', 'employee', 'branch', 'saleItems.product']));
});
