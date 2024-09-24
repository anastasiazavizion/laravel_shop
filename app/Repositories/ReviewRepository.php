<?php
namespace App\Repositories;

use App\Repositories\Contract\ReviewRepositoryContract;
use App\Models\Product;

class ReviewRepository implements ReviewRepositoryContract
{

    public function getAll(Product $product)
    {
       return $product->reviews()->latest()->get();
    }

    public function create(Product $product, array $data)
    {
        return $product->reviews()->create($data);
    }
}
