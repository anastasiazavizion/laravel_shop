<?php

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Admin\CategoriesController as AdminCategoriesController;
use App\Http\Controllers\Admin\ProductsController as AdminProductsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishListController;



Route::get('/test', function (){


} );


Route::get('/user', [UserController::class, 'user'])->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'authenticate'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

Route::prefix('admin/data/')->middleware(['auth:sanctum','role:admin|moderator'])->name('admin.')->group(function (){
    Route::resource('categories', AdminCategoriesController::class)->except(['create', 'edit']);
    Route::resource('products', AdminProductsController::class);
});

Route::prefix('user')->name('user.')->group(function (){
    Route::resource('categories', CategoriesController::class)->only(['index']);
    Route::resource('products', ProductsController::class)->only(['index', 'show']);
});

Route::name('wishlist.')->middleware('auth:sanctum')->group(function (){
    Route::post('wishList/{product}', [WishListController::class, 'add']);
    Route::delete('wishList/{product}', [WishListController::class, 'remove']);
    Route::get('wishlist', [WishListController::class, 'getAll']);
});


Route::prefix('cart')->name('cart.')->middleware('auth:sanctum')->group(function (){
    Route::get('/get', [CartController::class, 'index'])->name('index');
    Route::post('/', [CartController::class, 'add'])->name('add');
    Route::put('/count/{product}', [CartController::class, 'count'])->name('count');
    Route::put('/user/', [CartController::class, 'updateCartForUserWithExisting'])->name('user.update.cart');
    Route::delete('/', [CartController::class, 'delete'])->name('delete');
});

Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');
