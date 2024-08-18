<?php

namespace App\Listeners;

use App\Events\OrderCreatedEvent;
use App\Notifications\NewOrderCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderCreatedListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreatedEvent $event): void
    {
        $event->order->notify(new NewOrderCreatedNotification());
    }
}
