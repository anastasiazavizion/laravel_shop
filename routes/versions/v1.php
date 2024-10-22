<?php

use App\Http\Controllers\V1\Admin\CategoriesController as AdminCategoriesController;
use App\Http\Controllers\V1\Admin\ProductsController as AdminProductsController;
use App\Http\Controllers\V1\Auth\AuthController;
use App\Http\Controllers\V1\Auth\RegisteredUserController;
use App\Http\Controllers\V1\Auth\UserController;
use App\Http\Controllers\V1\Callbacks\JoinTelegramController;
use App\Http\Controllers\V1\CartController;
use App\Http\Controllers\V1\CategoriesController;
use App\Http\Controllers\V1\InvoiceController;
use App\Http\Controllers\V1\OrderController;
use App\Http\Controllers\V1\Payments\PaypalController;
use App\Http\Controllers\V1\ProductsController;
use App\Http\Controllers\V1\WishListController;
use App\Http\Controllers\V1\ReviewController;
use App\Http\Controllers\V1\Callbacks\SocialAuthController;
use App\Http\Controllers\V1\Admin\AdminChartsController;
use App\Http\Controllers\V1\Admin\MapController;
use App\Http\Controllers\V1\Admin\UserController as AdminUsersController;
use App\Http\Controllers\V1\Admin\OrderController as AdminOrderController;


Route::post('/login', [AuthController::class, 'authenticate'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

Route::apiResource('categories', CategoriesController::class)->only(['index']);

Route::apiResource('products', ProductsController::class)
    ->only(['index', 'show'])->scoped(['product' => 'slug']);;

Route::prefix('paypal')->name('paypal.')->group(function () {
    Route::post('order', [PaypalController::class, 'create'])->name('order.create');
    Route::post('order/{vendorOrderId}/capture', [PaypalController::class, 'capture'])->name('order.capture');
});

Route::get('orderByVendorId', [OrderController::class, 'getOrderByVendorId'])->name('orderByVendorId');

Route::post('/auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback'])->name('auth.social.callback');

Route::apiResource('products/{product}/reviews', ReviewController::class)->only(['index', 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'user'])->name('user');

    Route::prefix('admin/data/')->middleware(['role:admin|moderator'])->name('admin.')->group(function () {
        Route::apiResource('categories', AdminCategoriesController::class);
        Route::apiResource('products', AdminProductsController::class)->scoped(['product' => 'slug']);;;
    });

    Route::name('admin.')->prefix('admin')->middleware(['role:admin|moderator'])->group(function () {

        Route::get('/ordersAmountByProducts', [AdminChartsController::class, 'ordersAmountByProducts'])->name('ordersAmountByProducts');
        Route::get('/ordersAmountByCities', [AdminChartsController::class, 'ordersAmountByCities'])->name('ordersAmountByCities');
        Route::get('/ordersAmountByStatuses', [AdminChartsController::class, 'ordersAmountByStatuses'])->name('ordersAmountByStatuses');
        Route::get('/ordersAmountByCategories', [AdminChartsController::class, 'ordersAmountByCategories'])->name('ordersAmountByCategories');
        Route::get('/ordersTotal', [AdminChartsController::class, 'ordersTotal'])->name('ordersTotal');
        Route::get('/allOrdersAmount', [OrderController::class, 'allOrdersAmount'])->name('allOrdersAmount');
        Route::get('/allProductsAmount', [AdminProductsController::class, 'allProductsAmount'])->name('allProductsAmount');
        Route::get('/allUsersAmount', [AdminUsersController::class, 'allUsersAmount'])->name('allUsersAmount');

        Route::apiResource('orders', AdminOrderController::class)->only(['destroy']);

        Route::get('/map/markers', [MapController::class, 'index'])->name('map.markers');

    });

    Route::apiResource('orders', OrderController::class)->only(['index', 'show', 'destroy']);

    Route::name('wishlist.')->group(function () {
        Route::post('wishList/{product}', [WishListController::class, 'add'])->name('wishlist.add');
        Route::delete('wishList/{product}', [WishListController::class, 'remove'])->name('wishlist.remove');
        Route::get('wishlist', [WishListController::class, 'getAll'])->name('wishlist.all');
    });

    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/get', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::put('/amount/{product}', [CartController::class, 'amount'])->name('amount');
        Route::put('/user/', [CartController::class, 'updateCartForUserWithExisting'])->name('user.update.cart');
        Route::delete('/', [CartController::class, 'delete'])->name('delete');
    });

    Route::get('/invoices/{order}', InvoiceController::class)->name('invoices.order');

    Route::name('callbacks.')->prefix('callbacks')->group(function () {
        Route::get('telegram', JoinTelegramController::class)->name('telegram')->middleware(['role:admin']);
    });

});
