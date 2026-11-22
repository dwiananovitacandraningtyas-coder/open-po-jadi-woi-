<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReviewController;

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\OrderController;

use App\Http\Controllers\User\OrderHistoryController;


// ==========================================
// HALAMAN UTAMA & KATALOG
// ==========================================

// Halaman utama
Route::get('/', [ProductController::class, 'catalog'])
    ->name('home');

// Katalog
Route::get('/katalog', [ProductController::class, 'catalog'])
    ->name('user.products.index');

// Detail produk
Route::get('/produk/{product}', [ProductController::class, 'show'])
    ->name('user.products.show');


// ==========================================
// LOGIN ADMIN & PEMBELI (SATU HALAMAN)
// ==========================================

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');


// ==========================================
// REGISTER PEMBELI
// ==========================================

Route::get('/user/register', [UserAuthController::class, 'showRegister'])
    ->name('user.register');

Route::post('/user/register', [UserAuthController::class, 'register'])
    ->name('user.register.process');


// ==========================================
// KERANJANG
// ==========================================

Route::post('/keranjang/tambah/{product}', [ProductController::class, 'addToCart'])
    ->name('user.cart.add');

Route::get('/keranjang', [ProductController::class, 'cart'])
    ->name('user.cart.index');

Route::delete('/keranjang/hapus/{product}', [ProductController::class, 'removeFromCart'])
    ->name('user.cart.remove');


// ==========================================
// FITUR USER / PEMBELI
// ==========================================

Route::middleware(['auth', 'role:pembeli'])->group(function () {

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('user.checkout.index');

    Route::post('/checkout', [CheckoutController::class, 'store'])
        ->name('user.checkout.store');


    // Review produk
    Route::post('/produk/{product}/review', [ReviewController::class, 'store'])
        ->name('user.reviews.store');


    // Riwayat pesanan
    Route::get('/user/orders', [OrderHistoryController::class, 'index'])
        ->name('user.orders.index');


    // Akun pembeli
    Route::get('/user/account', [UserAuthController::class, 'account'])
        ->name('user.account');


    // Logout pembeli
    Route::post('/user/logout', [AuthController::class, 'logout'])
        ->name('user.logout');

});


// ==========================================
// FITUR ADMIN
// ==========================================

Route::middleware(['auth', 'role:admin'])->group(function () {

    // DAFTAR PRODUK
    Route::get('/admin/products', [ProductController::class, 'index'])
        ->name('products.index');


    // TAMBAH PRODUK
    Route::post('/products', [ProductController::class, 'store'])
        ->name('products.store');


    // EDIT PRODUK
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
        ->name('products.edit');


    // UPDATE PRODUK
    Route::put('/products/{product}', [ProductController::class, 'update'])
        ->name('products.update');


    // HAPUS PRODUK
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])
        ->name('products.destroy');


    // ======================================
    // ORDER ADMIN
    // ======================================

    Route::get('/admin/orders', [OrderController::class, 'index'])
        ->name('admin.orders.index');

    Route::patch('/admin/orders/{id}/confirm-payment', [OrderController::class, 'confirmPayment'])
        ->name('admin.orders.confirmPayment');


    // ======================================
    // REVIEW ADMIN
    // ======================================

    Route::get('/admin/reviews', [AdminReviewController::class, 'index'])
        ->name('admin.reviews.index');


    // ======================================
    // AKUN ADMIN
    // ======================================

    Route::get('/admin/account', [AccountController::class, 'index'])
        ->name('admin.account.index');

    Route::put('/admin/account', [AccountController::class, 'update'])
        ->name('admin.account.update');


    // ======================================
    // LOGOUT ADMIN
    // ======================================

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

});