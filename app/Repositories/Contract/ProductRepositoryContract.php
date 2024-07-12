<?php
namespace App\Repositories\Contract;

use App\Http\Requests\Admin\Products\CreateRequest;
use App\Http\Requests\Admin\Products\UpdateRequest;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryContract
{
    public function create(CreateRequest $request) : Product;
    public function update(UpdateRequest $request,Product $product) : Product;
    public function getAll() : Collection;
}
