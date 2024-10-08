<?php

namespace App\Broadcasting;

use App\Enum\Role;
use App\Models\User;

class AdminChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user): array|bool
    {
        return $user->hasRole(Role::ADMIN->value);
    }
}
