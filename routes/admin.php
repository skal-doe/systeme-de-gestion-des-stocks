<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\MovementController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::prefix('admin')->name('admin.')->group(function () {
    /*----------------------------------------------------------------------------------
     * ---Produits
     * --------------------------------------------------------------------------------
     */
    Route::resource('products', ProductController::class)->except(['show']);
    Route::controller(ProductController::class)->prefix('products')->name('products.')->group(function () {
        Route::get('corbeille', 'trash')->name('trash');
        Route::post('{product}/restore', 'restore')->name('restore');
        Route::delete('{product}/force-delete', 'forceDelete')->name('force-delete');
    });

    /*----------------------------------------------------------------------------------
     * ---Catégories
     * --------------------------------------------------------------------------------
     */
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::controller(CategoryController::class)->prefix('categories')->name('categories.')->group(function () {
        Route::get('corbeille', 'trash')->name('trash');
        Route::post('{product}/restore', 'restore')->name('restore');
        Route::delete('{product}/force-delete', 'forceDelete')->name('force-delete');
    });

    /*----------------------------------------------------------------------------------
     * ---Mouvements
     * --------------------------------------------------------------------------------
     */
    Route::resource('movements', MovementController::class);
    })->middleware(['auth', 'verified']);
