<?php

namespace App\Policies;

use App\Models\CustomerGroups;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CustomerGroupsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('list customer groups');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CustomerGroups $customerGroups): bool
    {
        return $user->can('list customer groups');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create customer groups');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CustomerGroups $customerGroups): bool
    {
        return $user->can('update customer groups');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CustomerGroups $customerGroups): bool
    {
        return $user->can('delete customer groups');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CustomerGroups $customerGroups): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CustomerGroups $customerGroups): bool
    {
        return false;
    }
}
