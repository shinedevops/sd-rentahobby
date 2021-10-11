<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your admin. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Category routes
    Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'admin'])->name('home');
    Route::get('categories', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories');
    Route::get('categories/add', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('addcategory');
    Route::post('categories', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('savecategory');
    Route::get('categories/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'show'])->name('viewcategory');
    Route::get('categories/{category}/edit', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('editcategory');
    Route::post('categories/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('updatecategory');
    Route::get('categories/{category}/delete', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('deletecategory');
    Route::get('categories/{category}/products', [App\Http\Controllers\Admin\CategoryController::class, 'products'])->name('categoryproduct');
    Route::get('categories/{category}/product/{product}', [App\Http\Controllers\Admin\CategoryController::class, 'editProduct'])->name('editproduct');
    Route::post('categories/{category}/product/{product}', [App\Http\Controllers\Admin\CategoryController::class, 'updateProduct'])->name('updateproduct');

    // global setting
    Route::get('settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings');
    Route::get('settings/{setting}/edit', [App\Http\Controllers\Admin\SettingController::class, 'edit'])->name('editsetting');
    Route::post('settings/{setting}', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('updatesetting');
    
    // Profile
    Route::get('profile', [App\Http\Controllers\ProfileController::class, 'profile'])->name('profile');
    Route::post('save-user-detail', [App\Http\Controllers\ProfileController::class, 'saveUserDetail'])->name('saveuserdetail');
    Route::post('update-password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('updatepassword');


});