<?php

namespace App\Listeners;

use App\Events\ProductInfoWasUpdated;
use App\Services\Contracts\CacheServiceContract;

class ProductInfoWasUpdatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProductInfoWasUpdated $event): void
    {
        $cacheService = app(CacheServiceContract::class);
        $cacheService->removeValueCacheByKey(config('cache.default_keys.products'),'product_'.$event->product->id);
    }
}
