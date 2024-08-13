<?php
namespace App\Enum;

enum QueueTypes: string
{
    case WISHLIST = 'wishlist';
    case WISHLIST_NOTIFICATION = 'wishlist-notifications';
}
