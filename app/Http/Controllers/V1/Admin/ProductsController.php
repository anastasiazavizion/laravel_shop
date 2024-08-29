<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\CreateRequest;
use App\Http\Requests\Admin\Products\UpdateRequest;
use App\Http\Resources\V1\Products\ProductResource;
use App\Http\Resources\V1\Products\ProductsCollection;
use App\Models\Product;
use App\Repositories\Contract\ProductRepositoryContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
class ProductsController  extends Controller
{
    public function __construct(protected ProductRepositoryContract $repository)
    {
        $this->authorizeResource(Product::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): ProductsCollection
    {
        return new ProductsCollection($this->repository->getAll());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request): JsonResponse
    {
        if($product = $this->repository->create($request)){
            return response()->json(['message' => "Product $product->title was created", 'data'=>new ProductResource($product)], 200);
        }
        return response()->json(['message' => 'Something was wrong', 'data'=>[]], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product  $product): ProductResource
    {
        $product->load(['categories', 'images']);
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Product $product): JsonResponse
    {
        if($this->repository->update($product,$request)){
            return response()->json(['message' => "Product $product->title was updated", 'data'=>new ProductResource($product)], 200);
        }
        return response()->json(['message' => 'Something was wrong', 'data'=>[]], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): JsonResponse
    {
        try {
            DB::beginTransaction();
            $title = $product->title;
            $product->delete();
            DB::commit();
            return response()->json(['message' => "Product $title was removed", 'data'=>new ProductResource($product)], 200);
        }catch (\Exception $exception){
            DB::rollBack();
            logs()->error($exception->getMessage());
            return response()->json(['message' => $exception->getMessage(), 'data'=>[]], $exception->getCode());
        }
    }
}
