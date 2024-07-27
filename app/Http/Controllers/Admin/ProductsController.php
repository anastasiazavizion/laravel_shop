<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\CreateRequest;
use App\Http\Requests\Admin\Products\UpdateRequest;
use App\Models\Product;
use App\Repositories\Contract\ProductRepositoryContract;


class A{
    private static $instance = null;

    private function __construct(){}

    public static function getInstance()
    {
        if(is_null(self::$instance)){
            self::$instance = new self();
        }
        return  self::$instance;
    }
}



class ProductsController  extends Controller
{
    public function __construct(protected ProductRepositoryContract $repository)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $obj1 = A::getInstance();

        echo $obj1::$str;

        $obj2 = A::getInstance();
        echo "<br>";
        echo $obj2::$str;

        die;



        return response()->json($this->repository->getAll());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        if($product = $this->repository->create($request)){
            return response()->json(['message' => "Product $product->title was created", 'data'=>$product], 200);
        }
        return response()->json(['message' => 'Something was wrong', 'data'=>[]], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product  $product)
    {
        $product->load(['categories', 'images']);
        return response()->json($product, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Product $product)
    {
        if($this->repository->update($product,$request)){
            return response()->json(['message' => "Product $product->title was updated", 'data'=>$product], 200);
        }
        return response()->json(['message' => 'Something was wrong', 'data'=>[]], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->middleware('permission:delete product');
        $title = $product->title;
        $product->delete();
        return response()->json(['message' => "Product $title was removed"], 200);
    }
}
