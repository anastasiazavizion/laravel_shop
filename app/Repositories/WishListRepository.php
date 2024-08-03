<?php
namespace App\Repositories;
use App\Enum\WishListType;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Contract\WishListRepositoryContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class WishListRepository implements WishListRepositoryContract
{
    public function __construct(public User $user)
    {

    }

    public function addToWish(Product $product, string $type = WishListType::PRICE->value): bool
    {
        try{
            $wished = $this->user->wishes()->find($product);
            if($wished){
                $this->user->wishes()->updateExistingPivot($wished, [$type => true]);
            }else{
                $this->user->wishes()->attach($product, [$type => true]);
            }
            return true;
        }catch (\Throwable $e){
            return false;
        }
    }

    public function removeFromWish(Product $product, string $type = WishListType::PRICE->value): bool
    {
        try {
            $this->user->wishes()->updateExistingPivot($product, [$type => false]);
            $product = $this->user->wishes()->find($product);
            if (!$product->pivot->exist && !$product->pivot->price) {
                $this->user->wishes()->detach($product);
            }
            return true;
        }catch (\Throwable $e){
            return false;
        }
    }

    public function getAll() : Collection|LengthAwarePaginator
    {
        return Auth::user()->wishes()->paginate(config('app.products_limit'));
    }

}
