<?php

namespace App\Jobs\WishList;
use App\Notifications\ProductAvailableNotification;

class ProductExistJob  extends  BaseJob
{

    public function handle(): void
    {
        $this->sendNotifications(ProductAvailableNotification::class);
    }
}
