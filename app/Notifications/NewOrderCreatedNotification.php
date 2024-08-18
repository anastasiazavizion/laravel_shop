<?php

namespace App\Notifications;

use App\Services\Contracts\InvoiceServiceContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderCreatedNotification extends Notification
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
        $invoice->save('public');

        logs()->info(storage_path('app/public/'.$invoice->filename));
        //message	'Unable to open path "http://localhost:8088/storage/invoices/roxane-oreilly-06d08405cb698963f.pdf".'
        return (new MailMessage)
                    ->subject('New Order on '.env('APP_NAME'))
                    ->greeting("Hello, {$order->name} {$order->lastname}")
                    ->line('Thank you for order!')
                    ->line('You can check invoice attachment')
                    ->attach(storage_path('app/public/'.$invoice->filename));
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
