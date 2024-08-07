<?php

namespace App\Notifications;

use App\Enum\QueueTypes;
use App\Mail\PriceUpdatedMail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class PriceUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Product $product)
    {
        $this->onQueue(QueueTypes::WISHLIST->value);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */

    //$notifiable  - User object
    //in via can check user and change mail to others
    public function via(User $user): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(User $user)
    {
        return (new PriceUpdatedMail($this->product, $user))
            ->to($user->email);

    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [

        ];
    }
}
