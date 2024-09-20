<?php

namespace App\Jobs\WishList;

use App\Notifications\PriceUpdatedNotification;

class PriceUpdatedJob extends BaseJob
{
    public function handle(): void
    {
        $this->sendNotifications(PriceUpdatedNotification::class);

    }
}
