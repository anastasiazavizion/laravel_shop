<?php
namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Products\ProductResource;
use App\Http\Resources\V1\Products\ProductsCollection;
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
        return new ProductsCollection($this->repository->getAll(true, $request->all()));
    }

    public function show(Product  $product)
    {
        $product->load(['categories']);
        $product->gallery = $this->repository->getGallery($product);
        return new ProductResource($product);
    }
}