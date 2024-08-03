<?php
namespace App\Repositories\Contract;

use App\Enum\WishListType;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface WishListRepositoryContract
{
    public function addToWish(Product $product, string $type = WishListType::PRICE->value): bool;

    public function removeFromWish(Product $product, string $type = WishListType::PRICE->value): bool;

    public function getAll() : Collection|LengthAwarePaginator;
}
