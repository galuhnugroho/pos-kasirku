<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('users', UserController::class);
    Route::patch('users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggleActive');
});

Route::middleware(['auth'])->prefix('kasir')->name('kasir.')->group(function () {
    //halaman pos
    Route::get('pos', [TransactionController::class, 'pos'])->name('pos');
    Route::get('history', [TransactionController::class, 'history'])->name('history');

    Route::post('cart/add', [TransactionController::class, 'addToCart'])->name('cart.add');
    Route::post('cart/update', [TransactionController::class, 'updateCart'])->name('cart.update');
    Route::post('cart/remove', [TransactionController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('cart/clear', [TransactionController::class, 'clearCart'])->name('cart.clear');

    Route::post('checkout', [TransactionController::class, 'checkout'])->name('checkout');
    Route::get('receipt/{transaction}', [TransactionController::class, 'receipt'])->name('receipt');
});
