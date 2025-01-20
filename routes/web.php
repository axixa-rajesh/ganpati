<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Models\Cart;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/product/all', [ProductController::class, 'listing']);
Route::resource('/product', ProductController::class);
Route::resource('/cart', CartController::class);
