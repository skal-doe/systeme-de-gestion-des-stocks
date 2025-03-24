<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\MovementController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UserController;
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
        Route::get('{product}', 'show')->name('show');
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
        Route::post('{categorie}/restore', 'restore')->name('restore');
        Route::delete('{categorie}/force-delete', 'forceDelete')->name('force-delete');
    });

    /*----------------------------------------------------------------------------------
     * ---Mouvements
     * --------------------------------------------------------------------------------
     */
    Route::resource('movements', MovementController::class);

    /*----------------------------------------------------------------------------------
     * ---Fournisseurs
     * --------------------------------------------------------------------------------
     */
    Route::resource('suppliers', SupplierController::class)->except(['show']);
    Route::controller(SupplierController::class)->prefix('suppliers')->name('suppliers.')->group(function () {
        Route::get('corbeille', 'trash')->name('trash');
        Route::get('{supplier}', 'show')->name('show');
        Route::post('{supplier}/restore', 'restore')->name('restore');
        Route::delete('{supplier}/force-delete', 'forceDelete')->name('force-delete');
    });

    /*----------------------------------------------------------------------------------
     * ---Utilisateurs
     * --------------------------------------------------------------------------------
     */
    Route::resource('users', UserController::class);
})->middleware(['auth', 'verified']);
