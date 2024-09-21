<?php

namespace App\Notifications;

use App\Services\Contracts\InvoiceServiceContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class NewOrderCreatedNotification extends Notification  implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
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
    public function toMail(object $order): MailMessage
    {
        $invoiceService = app(InvoiceServiceContract::class);
        $invoice = $invoiceService->generate($order);
        $invoice->save('s3');

        logs()->info('FILENAME='.$invoice->filename);

        Storage::setVisibility($invoice->filename, 'public');

        logs()->info('PATH='.Storage::url($invoice->filename));
        logs()->info('PATH2='.Storage::temporaryUrl($invoice->filename, now()->addMinutes(10)));

        return (new MailMessage)
                    ->subject('New Order on '.env('APP_NAME'))
                    ->greeting("Hello, {$order->name} {$order->lastname}")
                    ->line('Thank you for order!')
                    ->line('You can check invoice attachment');
                    /*->attach(Storage::url($invoice->filename));*/
    }

}
