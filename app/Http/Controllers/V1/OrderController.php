<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\GetOrdersRequest;
use App\Http\Requests\Order\OrderByVendorRequest;
use App\Http\Resources\V1\Orders\OrderCollection;
use App\Http\Resources\V1\Orders\OrderResource;
use App\Http\Resources\V1\Products\ProductResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

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

    /**
     * Display a listing of the resource.
     */
    public function index(GetOrdersRequest $request): OrderCollection
    {
        $data = $request->validated();
        $orders = Order::with(['products','transaction','status'])
            ->when(isset($data['user_id']), function ($query) use ($data){
                 $query->where('user_id', $data['user_id']);
            })
            ->latest()->paginate(10);
        return new OrderCollection($orders);
    }

    public function show(Order $order): OrderResource
    {
        $order->load(['products','transaction','status']);
        return new OrderResource($order);
    }

    //TODO move to admin
/*    public function destroy(Order $order): JsonResponse
    {
        try {
            DB::beginTransaction();
            $order->delete();
            DB::commit();
            return response()->json(['message' => "Order #$order->id was removed", 'data'=>new OrderResource($order)], 200);
        }catch (\Exception $exception){
            DB::rollBack();
            logs()->error($exception->getMessage());
            return response()->json(['message' => $exception->getMessage(), 'data'=>[]], $exception->getCode());
        }
    }
    */


    public function destroy(OrderByVendorRequest $request): JsonResponse
    {
        $data = $request->validated();
        try {
            $order = Order::where('vendor_order_id', $data['id'])
                ->firstOrFail();
            DB::beginTransaction();
            $order->delete();
            DB::commit();
            return response()->json(['message' => "", 'data'=>new OrderResource($order)], 200);
        }catch (\Exception $exception){
            DB::rollBack();
            logs()->error($exception->getMessage());
            return response()->json(['message' => $exception->getMessage(), 'data'=>[]], $exception->getCode());
        }
    }


    public function allOrdersAmount(): int
    {
        return Order::count();
    }

}
