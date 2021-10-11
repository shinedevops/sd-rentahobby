<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your retailer/individual user. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'retailer'])->prefix('retailer')->name('retailer.')->group(function () {
    Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'retailer'])->name('home');

    // product routes
    Route::get('products', [App\Http\Controllers\Retailer\ProductController::class, 'index'])->name('products');
    Route::get('products/add', [App\Http\Controllers\Retailer\ProductController::class, 'create'])->name('addproduct');
    Route::post('products', [App\Http\Controllers\Retailer\ProductController::class, 'store'])->name('saveproduct');
    Route::get('products/{product}/edit', [App\Http\Controllers\Retailer\ProductController::class, 'edit'])->name('editproduct');
    Route::post('products/{product}', [App\Http\Controllers\Retailer\ProductController::class, 'update'])->name('updateproduct');
    Route::get('products/{product}/delete', [App\Http\Controllers\Retailer\ProductController::class, 'destroy'])->name('deleteproduct');

    // Profile
    Route::get('profile', [App\Http\Controllers\ProfileController::class, 'profile'])->name('profile');
    Route::post('save-user-detail', [App\Http\Controllers\ProfileController::class, 'saveUserDetail'])->name('saveuserdetail');
    Route::post('update-password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('updatepassword');
});