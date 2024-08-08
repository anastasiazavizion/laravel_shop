<?php

namespace App\Observers;

use App\Jobs\WishList\PriceUpdatedJob;
use App\Jobs\WishList\ProductExistJob;
use App\Models\Product;
use App\Notifications\PriceUpdatedNotification;

class WishListObserver
{
    public function updated(Product $product): void
    {
        match (true) {
            $product->final_price < $product->getOriginal('finalPrice') => PriceUpdatedJob::dispatch($product),
            $product->exist && $product->getOriginal('exist') => ProductExistJob::dispatch($product),
        };

    }
}
