<?php

namespace App\Enum\Permissions;
use App\Traits\RolesPermissions;

enum Product: string
{
    use RolesPermissions;

    case CREATE = 'create product';
    case EDIT = 'edit product';
    case DELETE = 'delete product';
}
