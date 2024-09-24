<?php

namespace App\Jobs;

use App\Models\Order;
use App\Notifications\NotCompletedOrderNotification;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CheckNotCompletedOrdersJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        logs()->info('CheckNotCompletedOrdersJob  '.now()->format('H:i:s'));
        Order::select(['id','email','name', 'lastname','total','created_at', 'vendor_order_id'])->whereHas('status', function ($query){
            $query->inProcess();
        })->get()->map(function ($order){
            $order->notify(new NotCompletedOrderNotification($order));
            if ($order->created_at < Carbon::now()->subHours(8)) {
                $order->delete();
            }
        });
    }
}
