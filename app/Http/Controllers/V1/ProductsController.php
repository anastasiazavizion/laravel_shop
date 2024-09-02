<?php
namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Products\ProductResource;
use App\Http\Resources\V1\Products\ProductsCollection;
use App\Models\Product;
use App\Repositories\Contract\ProductRepositoryContract;
use Illuminate\Http\Request;


/**
 * @OA\Post(
 *     path="/api/v1/admin/data/products",
 *     summary="Adds a new product",
 *     tags={"Admin Products"},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="title",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="SKU",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="description",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="price",
 *                     type="number"
 *                 ),
 *                 @OA\Property(
 *                     property="discount",
 *                     type="number"
 *                 ),
 *                 @OA\Property(
 *                     property="quantity",
 *                     type="number"
 *                 ),
 *                 @OA\Property(
 *                     property="thumbnail",
 *                     type="file",
 *                     description="Product thumbnail image"
 *                 ),
 *                 @OA\Property(
 *                     property="categories",
 *                     type="array",
 *                     @OA\Items(
 *                         type="integer"
 *                     )
 *                 ),
 *                 @OA\Property(
 *                     property="images",
 *                     type="array",
 *                     @OA\Items(
 *                          type="file"
 *                      ),
 *                      description="Product gallery images"
 *                 ),
 *             )
 *         )
 *     ),
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
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(
 *                     property="id",
 *                     type="integer",
 *                     example=1
 *                 ),
 *                 @OA\Property(
 *                     property="slug",
 *                     type="string",
 *                     example="electronics"
 *                 ),
 *                 @OA\Property(
 *                     property="title",
 *                     type="string",
 *                     example="Electronics"
 *                 ),
 *                 @OA\Property(
 *                     property="SKU",
 *                     type="string",
 *                     example="ELEC123"
 *                 ),
 *                 @OA\Property(
 *                     property="description",
 *                     type="string",
 *                     example="A high-quality electronic product."
 *                 ),
 *                 @OA\Property(
 *                     property="price",
 *                     type="number",
 *                     format="float",
 *                     example=99.99
 *                 ),
 *                 @OA\Property(
 *                     property="discount",
 *                     type="number",
 *                     format="float",
 *                     example=10.0
 *                 ),
 *                 @OA\Property(
 *                     property="rate",
 *                     type="number",
 *                     format="float",
 *                     example=4.5
 *                 ),
 *                 @OA\Property(
 *                     property="quantity",
 *                     type="integer",
 *                     example=100
 *                 ),
 *                 @OA\Property(
 *                     property="in_stock",
 *                     type="boolean",
 *                     example=true
 *                 ),
 *                 @OA\Property(
 *                     property="thumbnail_url",
 *                     type="string",
 *                     example="http://example.com/images/product.jpg"
 *                 ),
 *                 @OA\Property(
 *                     property="final_price",
 *                     type="number",
 *                     format="float",
 *                     example=89.99
 *                 ),
 *                 @OA\Property(
 *                     property="is_in_wish_list_exist",
 *                     type="boolean",
 *                     example=false
 *                 ),
 *                 @OA\Property(
 *                     property="is_in_wish_list_price",
 *                     type="boolean",
 *                     example=true
 *                 ),
 *                 @OA\Property(
 *                     property="gallery",
 *                     type="array",
 *                     @OA\Items(
 *                         type="string",
 *                         example="http://example.com/images/gallery1.jpg"
 *                     )
 *                 ),
 *                 @OA\Property(
 *                     property="categories",
 *                     type="array",
 *                     @OA\Items(
 *                         type="object",
 *                         @OA\Property(
 *                             property="id",
 *                             type="integer",
 *                             example=1
 *                         ),
 *                         @OA\Property(
 *                             property="name",
 *                             type="string",
 *                             example="Electronics"
 *                         ),
 *                         @OA\Property(
 *                             property="slug",
 *                             type="string",
 *                             example="electronics"
 *                         ),
 *                         @OA\Property(
 *                             property="parent",
 *                             type="object"
 *                         )
 *                     )
 *                 ),
 *                 @OA\Property(
 *                     property="images",
 *                     type="array",
 *                     @OA\Items(
 *                         type="object",
 *                         @OA\Property(
 *                             property="url",
 *                             type="string",
 *                             example="http://example.com/images/product1.jpg"
 *                         )
 *                     )
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
 *                 example="Something was wrong"
 *             ),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items()
 *             )
 *         )
 *     )
 *
 * )
 */

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected ProductRepositoryContract $repository)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ProductsCollection
    {
        return new ProductsCollection($this->repository->getAll(true, $request->all()));
    }

    public function show(Product  $product): ProductResource
    {
        $product->load(['categories']);
        $product->gallery = $this->repository->getGallery($product);
        return new ProductResource($product);
    }
}
