<?php

namespace App\Policies;

use App\Models\InspectionType;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InspectionTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-any-inspection-type') || $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return  $user->hasPermissionTo('view-inspection-type') || $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return  $user->hasPermissionTo('create-inspection-type') || $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return  $user->hasPermissionTo('update-inspection-type') || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return  $user->hasPermissionTo('delete-inspection-type') || $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return  $user->hasPermissionTo('restore-inspection-type') || $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        return  $user->hasPermissionTo('force-delete-inspection-type') || $user->isAdmin();
    }
}
