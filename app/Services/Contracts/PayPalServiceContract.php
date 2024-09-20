<?php
namespace App\Services\Contracts;

use App\Enum\TransactionStatus;
use App\Http\Requests\CreateOrderRequest;
use Illuminate\Support\Collection;

interface PayPalServiceContract
{
    public function create(Collection $cartItems) : string|null;

    public function capture(string $vendorOrderId) : TransactionStatus;

}
