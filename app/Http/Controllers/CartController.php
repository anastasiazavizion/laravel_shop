<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\CountRequest;
use App\Http\Requests\Cart\UpdateCartForUserWithExistingRequest;
use App\Http\Resources\CartItemsResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return  response()->json(CartItemsResource::collection(Auth::user()->cartItems()->with(['product'])->get())->response()->getData());
    }
    public function add(Request $request)
    {
        $user = \Auth::user();
        $product = $request->input('product');

        $cartItem = $user->cartItems()->where('product_id', $product['id'])->first();

        if ($cartItem) {
            $cartItem->amount += 1;
            $cartItem->save();
        } else {
            $user->cartItems()->create([
                'product_id' => $product['id'],
                'amount' => 1,
            ]);
        }
        return response()->json(['message' => 'Product added to cart']);

    }
    public function delete(Request $request)
    {
        Auth::user()->cartItems()->withProduct($request->product['id'])->delete();
        return response()->json(['message' => 'Product removed from cart']);
    }

    public function count(CountRequest $request, Product $product)
    {
        $data = $request->validated();
        Auth::user()->cartItems()->withProduct($data['id'])->update([
           'amount'=>$data['amount']
        ]);
        return response()->json(['message' => 'Product amount was updated']);
    }


    public function updateCartForUserWithExisting(UpdateCartForUserWithExistingRequest $request)
    {
        if(Auth::user()->cartItems->isEmpty()){

            $cartItems = array_map(function ($item) {
                return [
                    'product_id' => $item['id'],
                    'amount' => $item['amount'],
                ];
            }, $request->validated());

            Auth::user()->cartItems()->createMany($cartItems);
            return response()->json('Updated cart', 200);
        }

        return response()->json('User has a cart', 200);

    }
}
