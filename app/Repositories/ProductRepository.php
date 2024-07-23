<?php

namespace App\Repositories;
use App\Http\Requests\Admin\Products\CreateRequest;
use App\Http\Requests\Admin\Products\UpdateRequest;
use App\Models\Product;
use App\Repositories\Contract\ImageRepositoryContract;
use App\Repositories\Contract\ProductRepositoryContract;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryContract
{
    public function __construct(protected ImageRepositoryContract $imageRepository)
    {
    }

    public function create(CreateRequest $request) : Product|false
    {
        try {
            DB::beginTransaction();
            $data = $this->formRequestData($request);
            $product = Product::create($data['attributes']);
            $this->setProductRelationsData($product, $data);
            DB::commit();
            return $product;
        }catch(\Throwable $exception){
            DB::rollBack();
            logs()->error($exception->getMessage());
            return  false;
        }
    }

    public function update(Product $product,UpdateRequest $request) : bool
    {
        try {
            DB::beginTransaction();
            $data = $this->formRequestData($request);
            $product->update($data['attributes']);
            $this->setProductRelationsData($product, $data);
            DB::commit();
            return true;
        }catch(\Throwable $exception){
            DB::rollBack();
            dd($exception->getMessage());
            logs()->error($exception->getMessage());
            return  false;
        }
    }

    public function getAll() : Collection
    {
        return Product::query()->with(['categories'])->latest()->get();
    }

    public function setProductRelationsData(Product $product, array $data): void
    {

        $product->categories()->sync($data['categories']);
        if(!empty($data['attributes']['images'])){
            //product->images_dir - subdirectory
            $this->imageRepository->attach($product, 'images', $data['attributes']['images'], $product->images_dir);
        }
    }

    public function formRequestData(FormRequest $request) : array
    {
        return [
            'attributes'=>collect($request->validated())->except(['categories'])
                ->prepend(Str::slug($request->get('title')), 'slug')
                ->toArray(),
            'categories'=>$request->get('categories', [])
        ];
    }
}
