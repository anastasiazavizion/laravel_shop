<?php

namespace App\Listeners;

use App\Enum\Role;
use App\Events\OrderCreatedEvent;
use App\Jobs\GeocodeAddressJob;
use App\Models\User;
use App\Notifications\NewOrderCreatedNotification;
use App\Notifications\Admin\NewOrderCreatedAdminNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class OrderCreatedListener implements ShouldQueue
{

    public $queue = 'listeners';

    /**
     * Create the event listener.
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreatedEvent $event): void
    {
        GeocodeAddressJob::dispatch($event->order);

        $event->order->notify(new NewOrderCreatedNotification());

        Notification::send(
            User::role(Role::ADMIN->value)->get(),
            app(NewOrderCreatedAdminNotification::class, ['order'=>$event->order])
        );
    }
}
