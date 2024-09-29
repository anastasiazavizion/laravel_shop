<?php

namespace App\Observers;

use App\Events\ProductInfoWasUpdated;
use App\Models\Category;
use App\Models\Product;
use App\Services\Contracts\CacheServiceContract;

class CategoryObserver
{
    private function clearCache(Category $category): void
    {
        $category->products()->each(function ($product) {
            ProductInfoWasUpdated::dispatch($product);
        });
    }

    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        $category->products()->searchable();
        $this->clearCache($category);
    }

    /**
     * Handle the Category "deleting" event.
     */

    public function deleting(Category $category): void
    {
        $productIds = $category->products->pluck('id')->toArray();
        Product::whereIn('id', $productIds)->searchable();
        if ($category->children()->exists()) {
            $category->children()->update(['parent_id' => null]);
        }
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        if($category->children()->exists()){
            $category->children()->update(['parent_id'=>null]);
        }
        $this->clearCache($category);
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        $this->clearCache($category);
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        $this->clearCache($category);
    }
}
