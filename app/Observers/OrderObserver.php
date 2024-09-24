<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Product;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleting(Order $order): void
    {
        if($order->whereHas('status', function ($query){
            $query->inProcess();
        })->exists()){
            $order->products()->each(function ($product){
                $productItem = Product::find($product->id);
                if($productItem){
                    $productItem->update([
                        'quantity' => $productItem->quantity + (int)$product->pivot->quantity
                    ]);
                }
            });
        }
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
