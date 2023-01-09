<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
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


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/pages/{name}', [HomeController::class, 'show'])->name('pages');

Route::get('/products', [ControllersProductsController::class, 'index'])
    ->name('products');
Route::get('/products/{product}', [ProductsController::class, 'show'])
    ->name('products.show');

    
Route::get('/cart', [CartController::class, 'index'])
    ->name('cart');
Route::post('/cart', [CartController::class, 'store']);

Route::get('/checkout', [CheckoutController::class, 'create'])
    ->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store']);

Route::get('/payments/{order}/redirect', [PaymentsController::class, 'redirect'])
    ->name('payments.redirect');
Route::get('/payments/{order}/callback', [PaymentsController::class, 'callback'])
    ->name('payments.callback');
Route::get('/payments/{order}/cancel', [PaymentsController::class, 'cancel'])
    ->name('payments.cancel');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

require __DIR__.'/dashboard.php';