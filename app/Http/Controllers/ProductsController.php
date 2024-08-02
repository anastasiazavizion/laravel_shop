<?php
namespace App\Http\Controllers;
use App\Http\Resources\ProductResource;
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
        return response()->json(ProductResource::collection($this->repository->getAll(true, $request->all()))->response()->getData());
    }

    public function show(Product  $product)
    {
        $product->load(['categories']);
        return response()->json(['product'=>['data'=>$product, 'gallery'=>$this->repository->getGallery($product)]], 200);
    }

}
