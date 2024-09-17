<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Admin\Charts\OrdersAmountByStatusesCollection;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class AdminChartsController extends Controller
{
    public function ordersAmountByProducts()
    {
        return Product::select(['title'])->whereHas('orders')->
        withCount('orders')->orderByDesc('orders_count')->get()->pluck('orders_count','title');
    }

    public function ordersAmountByCities()
    {
        return Order::select('city', DB::raw('count(*) as total'))
            ->groupBy('city')
            ->get()->pluck('total','city');
    }

    public function ordersAmountByCategories()
    {
        return Product::query()->select('categories.name',DB::raw('count(*) as total'))->join('order_product','order_product.product_id','=','products.id')
            ->join('category_product','products.id','=','category_product.product_id')
            ->join('categories','categories.id','=','category_product.category_id')
            ->groupBy('category_product.category_id')->get()->pluck('total','name');
    }

    public function ordersAmountByStatuses()
    {
        return new OrdersAmountByStatusesCollection(OrderStatus::whereHas('orders')->withCount('orders')->get());
    }

    public function ordersTotal()
    {
        return Order::totalByStatus();
    }

}
