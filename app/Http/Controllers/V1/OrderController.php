<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderByVendorRequest;
use App\Http\Resources\V1\Orders\OrderResource;
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
            return new OrderResource($order);
        }catch (\Exception $exception){
            logs()->error($exception);
            return response()->json([], 500);
        }

    }
}
