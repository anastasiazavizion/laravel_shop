<?php

namespace App\Observers;

use App\Models\Product;
use App\Repositories\Contract\ImageRepositoryContract;
use App\Services\Contracts\FileServiceContract;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        $product->categories()->detach();
        $imageRepository = app(ImageRepositoryContract::class);
        $imageRepository->detach($product,'images');
        $fileService = app(FileServiceContract::class);
        $fileService->remove($product->thumbnail);
    }
}
