<?php
namespace App\Enum\Permissions;
use App\Traits\RolesPermissions;

enum Order: string
{
    use RolesPermissions;
    case EDIT = 'edit order';
    case DELETE = 'delete order';
}
