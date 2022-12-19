<?php

use App\Http\Controllers\Dashboard\CategoriesController;
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

// Categories CRUD
Route::group([
    'prefix' => '/dashboard/categories',
    'as' => 'dashboard.categories.',
    'controller' => CategoriesController::class,
], function() {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/', 'store')->name('store');
    Route::get('/{category}/edit', 'edit')->name('edit');
    Route::put('/{category}', 'update')->name('update');
    Route::delete('/{category}', 'destroy')->name('destroy');
});