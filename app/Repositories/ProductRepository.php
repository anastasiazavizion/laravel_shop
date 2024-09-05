<?php

namespace App\Repositories;

use App\Http\Requests\Admin\Products\CreateRequest;
use App\Http\Requests\Admin\Products\UpdateRequest;
use App\Http\Resources\V1\Products\ProductResource;
use App\Http\Resources\V1\Products\ProductsCollection;
use App\Models\Product;
use App\Repositories\Contract\ImageRepositoryContract;
use App\Repositories\Contract\ProductRepositoryContract;
use App\Services\Contracts\CacheServiceContract;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductRepository implements ProductRepositoryContract
{
    public function __construct(protected ImageRepositoryContract $imageRepository, protected CacheServiceContract $cacheService)
    {
    }

    public function create(CreateRequest $request): Product|false
    {
        try {
            DB::beginTransaction();
            $data = $this->formRequestData($request);
            $product = Product::create($data['attributes']);
            $this->setProductRelationsData($product, $data);
            DB::commit();
            return $product;
        } catch (\Throwable $exception) {
            DB::rollBack();
            logs()->error($exception->getMessage());
            return false;
        }
    }

    public function update(Product $product, UpdateRequest $request): bool
    {
        try {
            DB::beginTransaction();
            $data = $this->formRequestData($request);
            $product->update($data['attributes']);
            $this->setProductRelationsData($product, $data);
            DB::commit();
            return true;
        } catch (\Throwable $exception) {
            DB::rollBack();
            logs()->error($exception->getMessage());
            return false;
        }
    }

    public function getAll(bool $paginate = false, array $params = [])
    {
        $key = 'products_page_'.request('page', 1).'_'.(int)$paginate.'_params_'.md5(json_encode($params));
        $this->cacheService->saveCacheKeys(config('cache.default_keys.products'),$key);

        $data =  Cache::rememberForever($key, function () use ($paginate,$params) {
            $searchIds = [];
            if (!empty($params['search'])) {
                $searchResults = Product::search($params['search'])->get();
                $searchIds = $searchResults->pluck('id');
            }
            $query = Product::query()
                ->when(!empty($searchIds), function ($q) use ($searchIds) {
                    $q->whereIn('id', $searchIds);
                })
                ->when((!empty($params['ids'])), function ($q) use ($params) {
                    $q->whereIn('id', $params['ids']);
                })
                ->when(!empty($params['categoryName']), function ($q) use ($params) {
                    $q->whereHas('categories', function ($query) use ($params) {
                        $query->where('slug', $params['categoryName']);
                    });
                })
                ->when(!empty($params['sort']), function ($q) use ($params) {
                    $q->orderBy($params['sort']['column'], $params['sort']['direction']);
                })
                ->with(['categories', 'images'])->latest();

            if ($paginate) {
                return  $query->paginate(config('app.products_limit'));
            }else{
                return  $query->get();
            }
        });
        return new ProductsCollection($data);
    }

    public function setProductRelationsData(Product $product, array $data): void
    {
        $product->categories()->sync($data['categories']);
        if (!empty($data['attributes']['images'])) {
            $this->imageRepository->attach($product, 'images', $data['attributes']['images'], $product->images_dir);
        }
        if (!empty($data['deleted_images'])) {
            $this->imageRepository->detach($product, 'images', $data['deleted_images']);
        }
    }

    public function formRequestData(FormRequest $request): array
    {
        return [
            'attributes' => collect($request->validated())->except(['categories', 'deleted_images'])
                ->prepend(Str::slug($request->get('title')), 'slug')
                ->toArray(),
            'categories' => $request->get('categories', []),
            'deleted_images' => $request->get('deleted_images', []),
        ];
    }

    public function getGallery(Product $product): array
    {
        return [
            $product->thumbnail_url,
            ...$product->images->map(function ($image) {
                return $image->url;
            })
        ];
    }

    public function getProduct(Product $product): JsonResource
    {
        $key = 'product_'.$product->id;
        $this->cacheService->saveCacheKeys(config('cache.default_keys.products'),$key);
        $data =  Cache::rememberForever('product_'.$product->id, function () use ($product) {
            $product->load(['categories','images']);
            $product->gallery = $this->getGallery($product);
            return $product;
        });
        return new ProductResource($data);
    }
}
