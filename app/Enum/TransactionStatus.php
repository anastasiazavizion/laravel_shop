<?php

namespace App\Enum;

enum TransactionStatus : string
{
    case SUCCESS = 'Success';
    case CANCELLED = 'Canceled';
    case PENDING = 'Pending';
}
