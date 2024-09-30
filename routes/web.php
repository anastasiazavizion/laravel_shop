<?php

use App\Jobs\GeocodeAddressJob;
use Illuminate\Support\Facades\Route;

/*Route::get('/test', function () {

    $order = \App\Models\Order::find(13);
    $results = app("geocoder")
        ->geocode("$order->city $order->address")
        ->get();

    $coordinates = $results[0]->getCoordinates();

    dd($coordinates);



    GeocodeAddressJob::dispatch($order);

    die;

});*/


Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');
