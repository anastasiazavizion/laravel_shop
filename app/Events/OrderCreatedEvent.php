<?php
namespace App\Events;
use App\Models\Order;
use App\Notifications\NewOrderCreatedNotification;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class OrderCreatedEvent
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Order $order)
    {
        $this->order->notify(new NewOrderCreatedNotification());
    }
}
