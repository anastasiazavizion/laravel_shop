<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\AllProductsRequest;
use App\Http\Requests\Admin\Products\CreateRequest;
use App\Http\Requests\Admin\Products\UpdateRequest;
use App\Http\Resources\V1\Products\ProductResource;
use App\Models\Product;
use App\Repositories\Contract\ProductRepositoryContract;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;


class ProductsController  extends Controller
{

    public function __construct(protected ProductRepositoryContract $repository)
    {

    }

    /**
     * @OA\Get(
     *     path="/api/v1/admin/data/products",
     *     summary="Get a list of products",
     *     tags={"Admin Products"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number for pagination",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of items per page",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A list of products",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Product")
     *             ),
     *             @OA\Property(
     *                 property="meta",
     *                 type="object",
     *                 @OA\Property(
     *                     property="current_page",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="per_page",
     *                     type="integer",
     *                     example=15
     *                 ),
     *                 @OA\Property(
     *                     property="total",
     *                     type="integer",
     *                     example=100
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="links",
     *                 type="object",
     *                 @OA\Property(
     *                     property="first",
     *                     type="string",
     *                     example="http://example.com/api/v1/admin/data/products?page=1"
     *                 ),
     *                 @OA\Property(
     *                     property="last",
     *                     type="string",
     *                     example="http://example.com/api/v1/admin/data/products?page=7"
     *                 ),
     *                 @OA\Property(
     *                     property="prev",
     *                     type="string",
     *                     nullable=true,
     *                     example=null
     *                 ),
     *                 @OA\Property(
     *                     property="next",
     *                     type="string",
     *                     example="http://example.com/api/v1/admin/data/products?page=2"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Something went wrong"
     *             )
     *         )
     *     )
     * )
     */
    public function index(AllProductsRequest $request)
    {
        Gate::authorize('viewAny', Product::class);
        return $this->repository->getAll(false, $request->validated());
    }

    /**
     * @OA\Post(
     *     path="/api/v1/admin/data/products",
     *     summary="Add a new product",
     *     tags={"Admin Products"},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/ProductRequestBody")
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Product created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Product Electronics was created"
     *             ),
     *             @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Product"
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Something was wrong"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items()
     *             )
     *         )
     *     )
     * )
     */
    public function store(CreateRequest $request)
    {
        Gate::authorize('create', Product::class);
        if($product = $this->repository->create($request)){
            return response()->json(['message' => "Product $product->title was created", 'data'=>new ProductResource($product)], 200);
        }
        return response()->json(['message' => 'Something was wrong', 'data'=>[]], 500);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/admin/data/products/{product}",
     *     summary="Get a specific product by ID",
     *     tags={"Admin Products"},
     *     @OA\Parameter(
     *         name="product",
     *         in="path",
     *         description="The ID of the product to retrieve",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product details",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/Product"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Product not found"
     *             )
     *         )
     *     )
     * )
     */

    public function show(Product  $product): JsonResource
    {
        Gate::authorize('view', $product);
        return $this->repository->getProduct($product);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/admin/data/products/{product}",
     *     summary="Update existing product",
     *     tags={"Admin Products"},
     *     @OA\Parameter(
     *          name="product",
     *          in="path",
     *          description="Products ID  to update",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/ProductRequestBody")
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Product updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Product Electronics was updated"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/Product"
     *               )
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Something was wrong"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items()
     *             ),
     *         )
     *     )
     *
     * )
     */
    public function update(UpdateRequest $request, Product $product): JsonResponse
    {
        Gate::authorize('update',$product);
        if($this->repository->update($product,$request)){
            return response()->json(['message' => "Product $product->title was updated", 'data'=>new ProductResource($product)], 200);
        }
        return response()->json(['message' => 'Something was wrong', 'data'=>[]], 500);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/admin/data/products/{product}",
     *     summary="Delete a specific product by ID",
     *     tags={"Admin Products"},
     *     @OA\Parameter(
     *         name="product",
     *         in="path",
     *         description="The ID of the product to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Product Electronics was removed"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/Product"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Product not found"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items()
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="An error occurred while trying to delete the product"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items()
     *             )
     *         )
     *     )
     * )
     */
    public function destroy(Product $product): JsonResponse
    {
        Gate::authorize('delete', $product);
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


    public function allProductsAmount(): int
    {
        return Product::count();
    }

}
