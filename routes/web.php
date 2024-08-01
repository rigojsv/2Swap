<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;

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

    //Carrito
    Route::post('/cart/add/{productId}', [CartController::class, 'addProduct'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
    Route::post('/cart/update/{itemId}', [CartController::class, 'updateCartItem'])->name('cart.update');
    Route::delete('/cart/remove/{itemId}', [CartController::class, 'removeCartItem'])->name('cart.remove');



    //Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/publications', [ProductController::class, 'myPublications'])->name('publications');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::get('/sells', function () {
        return view('sells');
    })->name('mysells');


    //Pagos del carrito
    Route::get('/paymentcart', [PaymentController::class, 'showPaymentPage'])->name('payment.cart');
    Route::post('/payment', [PaymentController::class, 'processPayment'])->name('payment.process');
    Route::post('/paymentcart', [ProductController::class, 'cartPayment'])->name('cart.payment');

    //agregar producto y cobro del mismo
    Route::get('/newproduct', [ProductController::class, 'create'])->name('product.create');
    Route::post('/newproduct', [ProductController::class, 'store'])->name('product.store');
    Route::get('/pago', [ProductController::class, 'showPaymentPage'])->name('payment.page');
});
