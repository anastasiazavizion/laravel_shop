<?php
namespace App\Repositories\Contract;

use App\Models\User;
use Illuminate\Support\Collection;

interface CartRepositoryContract
{
  public function getSubTotal($cartItems): float;
  public function convertCartItemsToCollection($cartItems): Collection;
  public function changeProductAmount(User $user, int $id, int $amount): bool;
  public function removeProductFromCart(User $user, int $id): bool;
  public function addProduct(User $user,int $id): bool;
}
