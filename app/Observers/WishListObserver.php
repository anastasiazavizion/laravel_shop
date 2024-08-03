<?php

namespace App\Observers;

use App\Models\Product;

class WishListObserver
{
    public function updated(Product $product): void
    {
        if($product->final_price < $product->getOriginal('finalPrice')){



        }


        if($product->exist  &&  $product->getOriginal('exist')){



        }

    }
}
