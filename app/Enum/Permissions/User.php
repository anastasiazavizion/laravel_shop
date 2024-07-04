<?php
namespace App\Enum\Permissions;

use App\Traits\RolesPermissions;

enum User: string
{
    use RolesPermissions;
    case EDIT = 'edit user';
    case DELETE = 'delete user';
}
