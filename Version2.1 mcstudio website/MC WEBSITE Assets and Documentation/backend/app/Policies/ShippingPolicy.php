<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Models\Shipping;

class ShippingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('list shippings');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Shipping $shipping): bool
    {
        return $user->can('list shippings');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create shippings');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Shipping $shipping): bool
    {
        return $user->can('update shippings');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Shipping $shipping): bool
    {
        return $user->can('delete shippings');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Shipping $shipping): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Shipping $shipping): bool
    {
        return false;
    }
}
