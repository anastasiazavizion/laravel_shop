<?php
namespace App\Repositories\Contract;

use App\Enum\PaymentSystemEnum;
use App\Enum\TransactionStatus;
use App\Models\Order;
use Illuminate\Support\Collection;
interface OrderRepositoryContract
{
    public function create(array $data, Collection $cartItems) : Order|false;

    public function setTransaction(string $vendorOrderId, PaymentSystemEnum $paymentSystem, TransactionStatus $paymentStatus) : Order;

}
