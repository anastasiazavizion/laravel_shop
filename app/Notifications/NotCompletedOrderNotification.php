<?php

namespace App\Notifications;

use App\Mail\NotCompletedOrderMail;
use App\Models\Order;
use Illuminate\Bus\Queueable;

use Illuminate\Notifications\Notification;

class NotCompletedOrderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Order $order)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): NotCompletedOrderMail
    {
        return (new NotCompletedOrderMail($this->order))->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
