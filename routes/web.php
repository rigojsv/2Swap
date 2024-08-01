<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;

Route::get('/', function () {
    return view('index');
})->name('index');
Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/shop/product/{id}', [ShopController::class, 'show'])->name('shop.show');


Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

Route::get('/newproduct', function () {
    return view('newproduct');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::post('/cart/add/{productId}', [CartController::class, 'addProduct'])->name('cart.add');

    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');

    Route::post('/cart/update/{itemId}', [CartController::class, 'updateCartItem'])->name('cart.update');

    Route::delete('/cart/remove/{itemId}', [CartController::class, 'removeCartItem'])->name('cart.remove');

    Route::get('/newproduct', [ProductController::class, 'create'])->name('product.create');

    Route::post('/newproduct', [ProductController::class, 'store'])->name('product.store');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    route::get('/publications', function() {
        return view('publications');
    })->name('publications');


});
