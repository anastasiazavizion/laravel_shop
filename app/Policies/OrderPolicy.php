<?php

namespace App\Policies;

use App\Enum\Role;
use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    protected function adminOrModerator($user)
    {
        return $user->hasAnyRole([Role::ADMIN->value, Role::MODERATOR->value]);
    }

    protected function admin($user)
    {
        return $user->hasAnyRole([Role::ADMIN->value]);
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->adminOrModerator($user);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Order $order): bool
    {
        return $this->adminOrModerator($user) || $user->id === $order->user_id;

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->adminOrModerator($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Order $order): bool
    {
        return $this->adminOrModerator($user);

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Order $order): bool
    {
        return $this->admin($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Order $order): bool
    {
        return $this->admin($user);

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Order $order): bool
    {
        return $this->admin($user);
    }
}
