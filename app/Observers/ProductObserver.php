<?php

namespace App\Observers;

use App\Models\Product;
use App\Repositories\Contract\ImageRepositoryContract;
use App\Services\Contracts\FileServiceContract;
use App\Observers\Traits\ClearProductsCache;

class ProductObserver
{
    use ClearProductsCache;

    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        $this->clearProductsCache();
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        $this->clearProductsCache();
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        $this->clearProductsCache();
        $product->categories()->detach();
        app(ImageRepositoryContract::class)->detach($product, 'images');
        $fileService = app(FileServiceContract::class);
        $fileService->remove($product->thumbnail);
    }

    public function restored(Product $product): void
    {
        $this->clearProductsCache();
    }


    public function forceDeleted(Product $product): void
    {
        $this->clearProductsCache();
    }
}
