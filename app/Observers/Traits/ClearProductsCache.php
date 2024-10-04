<?php
namespace App\Observers\Traits;

use App\Services\Contracts\CacheServiceContract;

trait ClearProductsCache
{
    public function clearProductsCache(): void
    {
        $cacheService = app(CacheServiceContract::class);
        $cacheService->removeAllCacheByKey(config('cache.default_keys.products'));
    }

}
