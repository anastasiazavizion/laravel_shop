<?php
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Admin\CategoriesController as AdminCategoriesController;
use App\Http\Controllers\Admin\ProductsController as AdminProductsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CategoriesController;

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




Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');
