<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
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
Auth::routes(['verify' => true]);

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/latestProducts', [HomeController::class, 'latestProducts'])->name('latestProducts');
Route::get('/products', [ProductController::class, 'index'])->name('product.index');
Route::group(
    [
        'middleware' => 'admin', 'prefix' => 'admin'
    ],
    function () {
        Route::get('/products/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/products', [ProductController::class, 'store'])->name('product.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('product.update');
    }
);
Route::post('/addToCart/{product}', [CartController::class, 'addProductToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
Route::delete('/cart/{product}', [CartController::class, 'removeProductFromCart'])->name('cart.destroy');
Route::post('/search', [HomeController::class, 'search'])->name('search');
