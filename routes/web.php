<?php
use Illuminate\Support\Facades\Route;

Route::redirect('login', 'nova/login')->name('login');

Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');
