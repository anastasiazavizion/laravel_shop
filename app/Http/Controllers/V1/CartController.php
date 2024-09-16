<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\AddProductRequest;
use App\Http\Requests\Cart\CountRequest;
use App\Http\Requests\Cart\DeleteProductRequest;
use App\Http\Requests\Cart\UpdateCartForUserWithExistingRequest;
use App\Http\Resources\V1\Cart\CartItemCollection;
use App\Models\Product;
use App\Repositories\Contract\CartRepositoryContract;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    public function __construct(public CartRepositoryContract $cartRepository)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): CartItemCollection
    {
        return new CartItemCollection(Auth::user()->cartItems()->with(['product'])->get());
    }

    public function add(AddProductRequest $request): JsonResponse
    {
        $data = $request->validated();
        if ($this->cartRepository->addProduct(Auth::user(), $data['id'])) {
            return response()->json(['message' => 'Product added to cart']);
        }
        return response()->json(['message' => 'Something was wrong', 'data' => []], 500);
    }

    public function delete(DeleteProductRequest $request): JsonResponse
    {
        $data = $request->validated();
        if ($this->cartRepository->removeProductFromCart(Auth::user(), $data['id'])) {
            return response()->json(['message' => 'Product removed from cart']);
        }
        return response()->json(['message' => 'Something was wrong', 'data' => []], 500);
    }

    public function amount(CountRequest $request, Product $product): JsonResponse
    {
        $data = $request->validated();
        if ($this->cartRepository->changeProductAmount(Auth::user(), $data['id'], $data['amount'])) {
            return response()->json(['message' => 'Product amount was updated']);
        }
        return response()->json(['message' => 'Something was wrong', 'data' => []], 500);
    }

    public function updateCartForUserWithExisting(UpdateCartForUserWithExistingRequest $request): JsonResponse
    {
        if ($this->cartRepository->updateCartForUserWithExisting(Auth::user(), $request->validated())) {
            return response()->json('Updated cart', 200);
        }
        return response()->json(['message' => 'Something was wrong', 'data' => []], 500);
    }
}
