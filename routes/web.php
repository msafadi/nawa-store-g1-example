<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/pages/{name}', [HomeController::class, 'show'])->name('pages');


Route::group([
    'prefix' => '/dashboard',
    'as' => 'dashboard.'
], function () {
    Route::group([
        'prefix' => '/categories',
        'as' => 'categories.',
        'controller' => CategoriesController::class,
    ], function() {
        Route::get('/trash', 'trash')->name('trash');
        Route::patch('/{category}/restore', 'restore')->name('restore');
        Route::delete('/{category}/force', 'forceDelete')->name('force-delete');
    });

    Route::resource('categories', CategoriesController::class)->except('show');
    Route::resource('products', ProductsController::class)->names([
        // 'index' => 'dashboard.products.index',
        // 'edit' =>  'dashboard.products.edit',
    ]);
});