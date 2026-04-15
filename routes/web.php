<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/shop', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::resource('products', ProductController::class);

Route::middleware(['auth', 'role:seller'])->group(function () {

    Route::resource('products', ProductController::class);
});

Route::get('/shop', [ProductController::class, 'shop']);

Route::get('/shop', [ProductController::class, 'shopIndex'])->name('shop.index');

Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart',[CartController::class, 'index'])->name('cart.index');
    Route::delete('/cart/remove/{id}',[CartController::class, 'remove'])->name('cart.remove');
});

require __DIR__ . '/auth.php';
