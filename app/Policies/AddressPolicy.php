<?php

namespace App\Policies;

use App\Models\Address;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AddressPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return  $user->hasPermissionTo('view-any-address')||$user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return  $user->hasPermissionTo('view-address')||$user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return  $user->hasPermissionTo('create-address')||$user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return  $user->hasPermissionTo('update-address')||$user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return  $user->hasPermissionTo('delete-address')||$user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return  $user->hasPermissionTo('restore-address')||$user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        return  $user->hasPermissionTo('force-delete-address')||$user->isAdmin();
    }
}
