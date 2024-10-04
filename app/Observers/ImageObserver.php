<?php

namespace App\Observers;

use App\Models\Image;
use App\Observers\Traits\ClearProductsCache;
use App\Services\Contracts\FileServiceContract;

class ImageObserver
{
    use ClearProductsCache;

    public function created(Image $image): void
    {
        $this->clearProductsCache();
    }

    public function updated(Image $image): void
    {
        $this->clearProductsCache();
    }

    /**
     * Handle the Image "deleted" event.
     */
    public function deleted(Image $image): void
    {
        $this->clearProductsCache();
        app(FileServiceContract::class)->remove($image->path);
    }

}
