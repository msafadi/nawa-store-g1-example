<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ProductsController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => '/dashboard',
    'as' => 'dashboard.',
    'middleware' => ['auth', 'verified'],
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