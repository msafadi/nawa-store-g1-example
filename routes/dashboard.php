<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\ProfileController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => '/dashboard',
    'as' => 'dashboard.',
    'middleware' => ['auth', 'user.type:super-admin,admin'],
], function () {

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('profile', [ProfileController::class, 'update']);

    Route::group([
        'prefix' => '/categories',
        'as' => 'categories.',
        'controller' => CategoriesController::class,
    ], function() {
        Route::get('/trash', 'trash')
            ->middleware('password.confirm')
            ->name('trash');
        Route::patch('/{category}/restore', 'restore')->name('restore');
        Route::delete('/{category}/force', 'forceDelete')->name('force-delete');
    });

    Route::resource('categories', CategoriesController::class)->except('show');
    Route::resource('products', ProductsController::class)->names([
        // 'index' => 'dashboard.products.index',
        // 'edit' =>  'dashboard.products.edit',
    ]);
});