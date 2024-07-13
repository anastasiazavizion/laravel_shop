<?php

namespace App\Repositories;
use App\Http\Requests\Admin\Products\CreateRequest;
use App\Http\Requests\Admin\Products\UpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\Contract\ProductRepositoryContract;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryContract
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function create(CreateRequest $request) : Product
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']);
        $data['thumbnail'] = '';
        $product =  Product::create($data);
        $product->categories()->attach($data['categories']);
        return $product;
    }

    public function update(UpdateRequest $request, Product $product) : Product
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']);
        $data['thumbnail'] = '';
        $product->update($data);
        $product->categories()->sync($data['categories']);
        return $product;
    }

    public function getAll() : Collection
    {
        return Product::query()->with(['categories'])->get();
    }
}
