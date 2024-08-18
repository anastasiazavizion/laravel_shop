<?php
namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contract\CartRepositoryContract;
use Illuminate\Support\Collection;

class CartRepository implements CartRepositoryContract
{

    public function getSubTotal($cartItems): float
    {
        return $cartItems->sum(function ($cartItem) {
            return $cartItem->product->price * $cartItem->amount;
        });
    }

    public function convertCartItemsToCollection($cartItems): Collection
    {
        return collect($cartItems)->map(function ($item) {
            $item['product'] = Product::find($item['id']);
            return (object) $item;
        });

    }
}
