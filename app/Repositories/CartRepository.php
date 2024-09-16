<?php
namespace App\Repositories;

use App\Models\Product;
use App\Models\User;
use App\Repositories\Contract\CartRepositoryContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CartRepository implements CartRepositoryContract
{

    public function getSubTotal($cartItems): float
    {
        return $cartItems->sum(function ($cartItem) {
            return $cartItem->product->price * $cartItem->amount;
        });
    }

    public function convertCartItemsToCollection($cartItems): Collection
    {
        return collect($cartItems)->map(function ($item) {
            $item['product'] = Product::find($item['id']);
            return (object) $item;
        });
    }

    public function changeProductAmount(User $user, int $id, int $amount): bool
    {
        try{
            $user->cartItems()->withProduct($id)->update([
                'amount'=>$amount
            ]);
            return true;
        }catch(\Exception $e){
            logs()->error($e->getMessage());
            return false;
        }
    }

    public function removeProductFromCart(User $user, int $id): bool
    {
        try{
            $user->cartItems()->withProduct($id)->delete();
            return true;
        }catch(\Exception $e){
            logs()->error($e->getMessage());
            return false;
        }
    }

    public function updateCartForUserWithExisting(User $user, array $data): bool
    {
        try{
            if($user->cartItems->isEmpty()){
                $cartItems = array_map(function ($item) {
                    return [
                        'product_id' => $item['id'],
                        'amount' => $item['amount'],
                    ];
                },$data);
                $user->cartItems()->createMany($cartItems);
            }
            return true;
        }catch(\Exception $e){
            logs()->error($e->getMessage());
            return false;
        }
    }

    public function addProduct(User $user,int $id): bool
    {
        try{
            $cartItem = $user->cartItems()->where('product_id', $id)->first();
            if ($cartItem) {
                $cartItem->amount += 1;
                $cartItem->save();
            } else {
                $user->cartItems()->create([
                    'product_id' => $id,
                    'amount' => 1,
                ]);
            }
            return true;
        }catch(\Exception $e){
            logs()->error($e->getMessage());
            return false;
        }
    }
}
