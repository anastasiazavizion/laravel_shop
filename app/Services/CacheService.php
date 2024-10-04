<?php

namespace App\Services;

use App\Services\Contracts\CacheServiceContract;
use Illuminate\Support\Facades\Cache;

class CacheService implements CacheServiceContract
{
    public function removeAllCacheByKey($key): void
    {
        $keysToDelete = Cache::get($key);

        if(!empty($keysToDelete)){
            foreach ($keysToDelete as $itemDel) {
                Cache::forget($itemDel);
            }
        }
        Cache::put($key,null);
    }

    public function removeValueCacheByKey($key, $value): void
    {
        $keysToDelete = Cache::get($key);
        if(in_array($value, $keysToDelete)){
            Cache::forget($value);
            if (($keyArray = array_search($value, $keysToDelete)) !== false) {
                unset($keysToDelete[$keyArray]);
            }
            Cache::put($key,$keysToDelete);
        }
    }

    public function saveCacheKeys($key, $value): void
    {
        $existingValues = Cache::get($key, []);
        if(!in_array($value, $existingValues)){
            $existingValues[] = $value;
        }
        Cache::put($key,$existingValues);
    }
}
