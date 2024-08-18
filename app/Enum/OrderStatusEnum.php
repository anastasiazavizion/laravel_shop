<?php
namespace App\Enum;
enum OrderStatusEnum: string
{
    case IN_PROCESS = 'In Process';
    case Paid = 'Paid';
    case CANCELLED = 'Cancelled';
    case COMPLETED = 'Completed';
}
