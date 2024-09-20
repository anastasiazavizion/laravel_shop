<?php

use App\Http\Controllers\V1\ProductsController;

Route::prefix('user')->name('user.')->group(function () {
    Route::apiResource('products', ProductsController::class)->only(['index', 'show']);
});
