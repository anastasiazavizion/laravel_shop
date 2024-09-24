<?php
namespace App\Repositories\Contract;

use App\Models\Product;

interface ReviewRepositoryContract
{
    public function getAll(Product $product);

    public function create(Product $product, array $data);
}
