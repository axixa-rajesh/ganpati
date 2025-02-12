<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\MyorderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShippingController;
use App\Models\Cart;
use App\Models\Shipping;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/product/all', [ProductController::class, 'listing']);
Route::middleware('auth')->group(function(){
    Route::resource('/product', ProductController::class);
    Route::resource('/cart', CartController::class);
    Route::resource('/myorder', MyorderController::class);
    Route::resource('/shipping', ShippingController::class);
});
