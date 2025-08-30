<?php

namespace App\Policies;

use App\Models\HousingType;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HousingTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-any-housing-type') || $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user ): bool
    {
        return $user->hasPermissionTo('view-housing-type') || $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-housing-type') || $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user ): bool
    {
        return $user->hasPermissionTo('update-housing-type') || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user ): bool
    {
        return $user->hasPermissionTo('delete-housing-type') || $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return $user->hasPermissionTo('restore-housing-type') || $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        return $user->hasPermissionTo('force-delete-housing-type') || $user->isAdmin();
    }
}
