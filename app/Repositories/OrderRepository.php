<?php
namespace App\Repositories;


use App\Enum\PaymentSystemEnum;
use App\Enum\TransactionStatus;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Repositories\Contract\OrderRepositoryContract;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class OrderRepository implements  OrderRepositoryContract
{
    public function create(array $data, Collection $cartItems): Order|false
    {
        $data['status_id'] = OrderStatus::inProcess()->first()->id;
        $order = auth()->check()
            ? auth()->user()->orders()->create($data)
            : Order::create($data);

        $this->addProductsToOrder($order, $cartItems);
        return $order;
    }

    protected function addProductsToOrder(Order $order, Collection $cartItems): void
    {
        $cartItems->each(function($item) use ($order) {
            $product = $item->product;
            $order->products()->attach($product, [
                'quantity' => $item->amount,
                'single_price' => $product->price,
                'name' => $product->title
            ]);

            $quantity = $product->quantity - $item->amount;

            if (!$product->update(['quantity' => $quantity])) {
                throw new Exception("Not enough product [$product->title] quantity");
            }
        });
    }

    public function setTransaction(string $vendorOrderId, PaymentSystemEnum $paymentSystem, TransactionStatus $paymentStatus): Order
    {
        $order = Order::where('vendor_order_id', $vendorOrderId)->first();
        $order->transaction()->create([
            'payment_system' => $paymentSystem->value,
            'status' => $paymentStatus->value
        ]);
        $order->update([
            'status_id' => $this->getOrderStatus($paymentStatus)->id
        ]);
        return $order;
    }

    protected function getOrderStatus(TransactionStatus $status): OrderStatus
    {
        return match($status) {
            TransactionStatus::SUCCESS => OrderStatus::paid()->first(),
            TransactionStatus::CANCELLED => OrderStatus::cancelled()->first(),
            default => OrderStatus::inProcess()->first()
        };
    }
}
