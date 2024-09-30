<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderCoordinate;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        $coordinates = OrderCoordinate::with(['order'])
            ->where('lat', '<>','')
            ->where('lng', '<>','')->get();

    /*    $coordinates = Order::with(['coordinates'])->whereHas('coordinates',function($q){
            $q->where('lat', '<>','')->andWhere('lng', '<>','');
        });*/
        return response()->json($coordinates);


    }
}
