<?php
namespace App\Repositories\Contract;

use Illuminate\Support\Collection;

interface CartRepositoryContract
{
  public function getSubTotal($cartItems): float;

  public function convertCartItemsToCollection($cartItems): Collection;
}
