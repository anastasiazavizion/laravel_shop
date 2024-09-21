<?php

use Illuminate\Support\Facades\Route;

Route::get('{any}', function () {

    if(Auth::check()){
        logs()->info('SEND MAIL');
        Mail::to(\Illuminate\Support\Facades\Auth::user())->send(new \App\Mail\TestMail());
    }

    return view('app');
})->where('any', '.*');
