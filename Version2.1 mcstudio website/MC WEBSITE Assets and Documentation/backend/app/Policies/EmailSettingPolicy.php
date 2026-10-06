<?php

namespace App\Policies;

use App\Models\EmailSetting;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EmailSettingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('list email settings');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, EmailSetting $emailSettings): bool
    {
        return $user->can('list email settings');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create email settings');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, EmailSetting $emailSettings): bool
    {
        return $user->can('update email settings');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, EmailSetting $emailSettings): bool
    {
        return $user->can('delete email settings');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, EmailSetting $emailSettings): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, EmailSetting $emailSettings): bool
    {
        return false;
    }
}
