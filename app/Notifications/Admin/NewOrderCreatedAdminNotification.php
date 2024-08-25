<?php

namespace App\Notifications\Admin;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class NewOrderCreatedAdminNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Order $order)
    {
        //
    }

    public function viaQueues(): array
    {
        return [
            'mail' => 'admin-mail',
            'telegram' => 'admin-telegram',
        ];
    }

    public function via(User $user): array
    {
        return $user?->telegram_id ? ['telegram', 'mail'] : ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(User $user): MailMessage
    {
        return (new MailMessage)
            ->subject('New order!')
            ->line($this->greeting($user))
            ->line('There is a new order')
            ->line('')
            ->line($this->total($this->order))
            ->action('Check this order', $this->dashboardUrl());
    }

    public function toTelegram(User $user)
    {
        return TelegramMessage::create()
            ->to($user->telegram_id)
            ->line($this->greeting($user))
            ->line('There is a new order')
            ->line('')
            ->line($this->total($this->order))
            ->button('Check this order', $this->dashboardUrl());
    }


    private function dashboardUrl(): string
    {
        return url('/admin/dashboard');
    }
    private function total(Order $order): string
    {
        return 'Total: ' .$order->total . ' ' . config('paypal.currency');
    }

    private function greeting(User $user): string
    {
        return 'Hello, ' . $user->name . ' ' . $user->lastname;
    }

}
