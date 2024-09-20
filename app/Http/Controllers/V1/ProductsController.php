<?php
namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\Contract\ProductRepositoryContract;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
        return $this->repository->getAll(true, $request->all());
    }

    public function show(Product  $product): JsonResource
    {
        return $this->repository->getProduct($product);
    }
}
