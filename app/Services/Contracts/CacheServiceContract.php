<?php
namespace App\Services\Contracts;

interface CacheServiceContract
{
    public function removeAllCacheByKey($key): void;
    public function removeValueCacheByKey($key,$value): void;
    public function saveCacheKeys($key, $value): void;
}
