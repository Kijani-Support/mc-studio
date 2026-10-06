<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class CustomerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('list customers');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $customer): bool
    {
        return $user->can('list customers', $customer->hasRole('Customer'));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create customers');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $customer): bool
    {
        return $user->can('update customers', $customer);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $customer): bool
    {
        return $user->can('delete customers');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $customer): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $customer): bool
    {
        return false;
    }
}
