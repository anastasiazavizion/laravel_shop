<?php
namespace App\Http\Controllers\V2;
use App\Http\Controllers\Controller;
use App\Http\Resources\V2\Products\ProductResource;
use App\Http\Resources\V2\Products\ProductsCollection;
use App\Models\Product;
use App\Repositories\Contract\ProductRepositoryContract;
use Illuminate\Http\Request;

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
    public function index(Request $request)
    {
        $products = $this->repository->getAll(true, $request->all());
        return new ProductsCollection($products);
    }

    public function show(Product  $product)
    {
        $product->load(['categories']);
        return response()->json(['product'=>['data'=>new ProductResource($product), 'gallery'=>$this->repository->getGallery($product)]], 200);
    }
}
