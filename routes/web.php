<?php

use App\Notifications\NewOrderCreatedNotification;
use Illuminate\Support\Facades\Route;

Route::get('{any}', function () {

    $order = \App\Models\Order::first();

    $order->notify(new NewOrderCreatedNotification());

    return view('app');
})->where('any', '.*');
