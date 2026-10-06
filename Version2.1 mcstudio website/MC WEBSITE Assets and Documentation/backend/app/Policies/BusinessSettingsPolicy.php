<?php

namespace App\Policies;

use App\Models\BusinessSettings;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BusinessSettingsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('list business settings');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BusinessSettings $businessSettings): bool
    {
        return $user->can('list business settings');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create business settings');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BusinessSettings $businessSettings): bool
    {
        return $user->can('update business settings');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BusinessSettings $businessSettings): bool
    {
        return $user->can('delete business settings');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BusinessSettings $businessSettings): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BusinessSettings $businessSettings): bool
    {
        return false;
    }
}
