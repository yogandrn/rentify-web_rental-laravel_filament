<?php

use App\Http\Controllers\FrontEnd\HomeController;
use App\Http\Controllers\FrontEnd\ProductController;
use App\Http\Controllers\FrontEnd\TransactionController;
use Illuminate\Support\Facades\Route;


// Route::get('/', [FrontController::class, 'index'])->name('front.index');

// Route::get('/transactions', [FrontController::class, 'transactions'])->name('front.transactions');

// Route::post('/transactions/detail', [FrontController::class, 'transaction_detail'])->name('front.transaction.detail');

// Route::get('/detail/{product:slug}', [FrontController::class, 'detail'])->name('front.detail');

// Route::get('/booking/{product:slug}', [FrontController::class, 'booking'])->name('front.booking');

// Route::post('/booking/{product:slug}/save', [FrontController::class, 'booking_save'])->name('front.booking_save');

// Route::get('/success-booking/{transaction}', [FrontController::class, 'success_booking'])->name('front.success.booking');

// Route::post('/checkout/finish', [FrontController::class, 'checkout_store'])->name('front.checkout.store');

// Route::get('/checkout/{product-slug}/payment', [FrontController::class, 'checkout_product'])->name('front.checkout.product');

// // get category
// Route::get('/category/{category:slug}', [FrontController::class, 'category'])->name('front.category');

// // get brand  
// Route::get('/brand/{brand:slug}/products', [FrontController::class, 'brand'])->name('front.brand');





// landing page
Route::get('/', [HomeController::class, 'index'])->name('home.index');

// list transactions
Route::get('/transactions', [TransactionController::class, 'index'])->name('transaction.index');

// detail transactions
Route::post('/transactions/detail', [TransactionController::class, 'transaction_detail'])->name('transaction.detail');

// detail products
Route::get('/products/{product:slug}', [ProductController::class, 'detail'])->name('product.detail');

// Route::get('/booking/check', [TransactionController::class, 'my_booking'])->name('transaction.my-booking');

// on success booking
Route::get('/booking/success/{transaction:code}', [TransactionController::class, 'success_booking'])->name('transaction.booking.success');

// on booking product 
Route::get('/booking/{product:slug}', [ProductController::class, 'booking'])->name('product.booking');

// store booking transaction
Route::post('/booking/{product:slug}/rent', [ProductController::class, 'rent_booking'])->name('product.booking.rent');

// payment booking
Route::get('/checkout/{product:slug}', [ProductController::class, 'checkout'])->name('product.checkout');

Route::post('/checkout/order', [TransactionController::class, 'checkout_order'])->name('transaction.checkout.order');

// get category
Route::get('/category/{category:slug}', [HomeController::class, 'category'])->name('home.category');

// get brand  
Route::get('/brand/{brand:slug}/products', [HomeController::class, 'brand'])->name('home.brand');
