<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Models\StockReturn;

class StockReturnPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('list stock returns');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, StockReturn $stockreturn): bool
    {
        return $user->can('list stock returns');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create stock returns');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, StockReturn $stockreturn): bool
    {
        return $user->can('update stock returns', $stockreturn);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, StockReturn $stockreturn): bool
    {
        return $user->can('delete stock returns', $stockreturn);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, StockReturn $stockreturn): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, StockReturn $stockreturn): bool
    {
        return false;
    }
}
