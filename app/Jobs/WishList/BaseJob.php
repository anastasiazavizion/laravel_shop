<?php
namespace App\Jobs\WishList;

use App\Enum\QueueTypes;
use App\Enum\WishListType;
use App\Models\Product;
use App\Notifications\PriceUpdatedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use \Illuminate\Database\Eloquent\Collection;

abstract class BaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Product $product)
    {
       $this->onQueue(QueueTypes::WISHLIST->value);
    }

    abstract public function handle(): void;

    protected function sendNotifications(string $notificationClass = '', string $type = WishListType::PRICE->value): void
    {
        $this->product->followers()->wherePivot($type, true)
        ->chunk(500, function (Collection $users) use ($notificationClass){
            \Notification::send($users, app($notificationClass,
            ['product'=>$this->product]));
        });

    }
}
