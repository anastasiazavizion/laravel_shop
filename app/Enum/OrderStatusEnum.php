<?php

namespace App\Enum;
enum OrderStatusEnum: string{
    case IN_PROCESS = 'In process';
    case Paid = 'Paid';
    case CANCELLED = 'Cancelled';
    case COMPLETED = 'Completed';
}
