<?php
namespace App\Repositories\Contract;

use App\Enum\PaymentSystemEnum;
use App\Enum\TransactionStatus;
use App\Http\Requests\Admin\Categories\CreateRequest;
use App\Http\Requests\Admin\Categories\UpdateRequest;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

interface OrderRepositoryContract
{
    public function create(array $data) : Order|false;

    public function setTransaction(string $vendorOrderId, PaymentSystemEnum $paymentSystem, TransactionStatus $paymentStatus) : Order;

}
