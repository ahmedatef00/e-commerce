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

Route::get('/home', [HomeController::class, 'latestProducts'])->name('home');
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
// Route::get('handle-payment', 'PayPalPaymentController@handlePayment')->name('make.payment');
Route::get('payment/paypal/cancel', 'PayPalPaymentController@paymentCancel')->name('paypal.payment.cancel');
Route::get('payment-error', 'PayPalPaymentController@paymentSuccess')->name('paypal-payment.error');

Route::post('payment/paypal', 'App\Http\Controllers\PaymentController@handlePayment')->name('payment.paypal');

Route::get('payment/paypal/status', 'App\Http\Controllers\PaymentController@paypalCallback')->name('paypal.payment.status');

// Route::get('payment/paypal/cancel', function (){
//     return redirect(route('cart.show'));
// })->name('paypal.payment.cancel');

// Route::get('paypal-error', function (){
//     dd('error happened while processing your payment');
// })->name('paypal-payment.error');
