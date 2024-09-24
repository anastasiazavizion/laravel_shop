<?php


namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Orders\OrderResource;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function destroy(Order $order): JsonResponse
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

}
