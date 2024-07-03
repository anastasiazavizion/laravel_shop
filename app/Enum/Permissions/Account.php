<?php

namespace App\Enum\Permissions;

use App\Traits\RolesPermissions;

enum Account: string
{
    use RolesPermissions;
    case EDIT = 'edit account';
    case DELETE = 'delete account';

}
