<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\WishListRequest;
use App\Models\Product;
use App\Repositories\Contract\WishListRepositoryContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    private function repositoryInstance()
    {
        return app()->make(WishListRepositoryContract::class, ['user' => Auth::user()]);
    }


    public function add(WishListRequest $request, Product $product) : JsonResponse
    {
        if($this->repositoryInstance()->addToWish($product, $request->get('type'))){
            return response()->json('Added to wishlist', 200);
        }

        return response()->json('Error', 500);
    }

    public function remove(WishListRequest $request, Product $product) : JsonResponse
    {
        if($this->repositoryInstance()->removeFromWish($product, $request->get('type'))){
            return response()->json('Removed from wishlist');
        }

        return response()->json('Error', 500);
    }

    public function getAll() : JsonResponse
    {
        return response()->json($this->repositoryInstance()->getAll());
    }
}
