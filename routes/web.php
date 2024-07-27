<?php
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ProductsController;





Route::get('/user', [UserController::class, 'user'])->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'authenticate'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

Route::middleware(['auth:sanctum','role:admin|moderator'])->name('admin.')->group(function (){
    Route::resource('categories', CategoriesController::class)->except(['create', 'edit']);
    Route::resource('products', ProductsController::class);
});


Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');
