<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;


class ClientPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->getPermissionsViaRoles()->pluck('name')->contains('view-any-client');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Client $client): bool
    {
        return $user->getPermissionsViaRoles()->pluck('name')->contains('view-client');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->getPermissionsViaRoles()->pluck('name')->contains('create-client');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Client $client): bool
    {
        return $user->getPermissionsViaRoles()->pluck('name')->contains('update-client');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Client $client): bool
    {
        return $user->getPermissionsViaRoles()->pluck('name')->contains('delete-client');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Client $client): bool
    {
        return $user->getPermissionsViaRoles()->pluck('name')->contains('restore-client');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Client $client): bool
    {
        return $user->getPermissionsViaRoles()->pluck('name')->contains('force-delete-client');
    }
}
