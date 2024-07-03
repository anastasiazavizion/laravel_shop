<?php

namespace App\Enum\Permissions;

use App\Traits\RolesPermissions;

enum Category: string
{
    use RolesPermissions;
    case CREATE = 'create category';
    case EDIT = 'edit category';
    case DELETE = 'delete category';
}
