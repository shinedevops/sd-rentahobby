<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);

Auth::routes();

Route::get('retailer/register', function () {
    return view('auth.register');
})->name('retailer.register');

Route::middleware(['auth', 'customer'])->prefix('/')->group(function () {
    Route::get('home', [App\Http\Controllers\HomeController::class, 'customer'])->name('home');
});
Route::get('product/{product}', [App\Http\Controllers\Customer\ProductController::class, 'view'])->name('viewproduct');
Route::get('book/{product}', [App\Http\Controllers\Customer\ProductController::class, 'book'])->name('book');
Route::get('vendor/{vendor}', [App\Http\Controllers\Customer\ProductController::class, 'vendor'])->name('vendor');
Route::post('add-favorite', [App\Http\Controllers\Customer\ProductController::class, 'addFavorite'])->name('addfavorite');
