<?php
namespace App\Repositories\Contract;

use App\Http\Requests\Admin\Products\CreateRequest;
use App\Http\Requests\Admin\Products\UpdateRequest;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

interface ProductRepositoryContract
{
    public function create(CreateRequest $request) : Product|false;
    public function update(Product $product,UpdateRequest $request) : bool;
    public function getAll(bool $paginate = false, array $params = []);
    public function getGallery(Product $product) :array;
    public function getProduct(Product $product): JsonResource;
}
