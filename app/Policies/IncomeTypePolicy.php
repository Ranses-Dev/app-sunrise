<?php

namespace App\Policies;

use App\Models\IncomeType;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class IncomeTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return   $user->hasPermissionTo('view-any-income-type') || $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return   $user->hasPermissionTo('view-income-type') || $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return  $user->hasPermissionTo('create-income-type') || $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return  $user->hasPermissionTo('update-income-type') || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return  $user->hasPermissionTo('delete-income-type') || $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return  $user->hasPermissionTo('restore-income-type') || $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        return  $user->hasPermissionTo('force-delete-income-type') || $user->isAdmin();
    }
}
