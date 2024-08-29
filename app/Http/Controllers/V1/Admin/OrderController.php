<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Orders\OrderCollection;
use App\Http\Resources\V1\Orders\OrderResource;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['products','transaction','status'])->latest()->paginate(10);
        return new OrderCollection($orders);
    }

    public function show(Order $order)
    {
        $order->load(['products','transaction','status']);
        return new OrderResource($order);
    }
}
