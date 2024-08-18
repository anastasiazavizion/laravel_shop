<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\OrderByVendorRequest;
use App\Models\Order;

class OrderController extends Controller
{
    public function getOrderByVendorId(OrderByVendorRequest $request)
    {
        $data = $request->validated();
        try {
            $order = Order::with(['transaction', 'status','products'])
                ->where('vendor_order_id', $data['id'])
                ->firstOrFail();
            return response()->json($order);
        }catch (\Exception $exception){
            logs()->error($exception);
            return response()->json([], 500);
        }

    }
}
