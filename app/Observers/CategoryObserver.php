<?php

namespace App\Observers;

use App\Models\Category;
use App\Models\Product;

class CategoryObserver
{
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
    }

    /**
     * Handle the Category "deleting" event.
     */

    public function deleting(Category $category): void
    {
        $productIds = $category->products->pluck('id')->toArray();
        Product::whereIn('id', $productIds)->searchable();
        if ($category->childs()->exists()) {
            $category->childs()->update(['parent_id' => null]);
        }
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        if($category->childs()->exists()){
            $category->childs()->update(['parent_id'=>null]);
        }
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
    }
}
