<?php

namespace App\Jobs\WishList;
use App\Enum\WishListType;
use App\Notifications\ProductAvailableNotification;

class ProductExistJob  extends  BaseJob
{

    public function handle(): void
    {
        $this->sendNotifications(ProductAvailableNotification::class, WishListType::EXIST->value);
    }
}
