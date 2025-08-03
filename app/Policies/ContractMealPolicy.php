<?php

namespace App\Policies;

use App\Models\ContractMeal;
use App\Models\User;


class ContractMealPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
      return $user->getPermissionsViaRoles()->pluck('name')->contains('view-any-contract-meal');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ContractMeal $contractMeal): bool
    {
        return $user->getPermissionsViaRoles()->pluck('name')->contains('view-contract-meal');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->getPermissionsViaRoles()->pluck('name')->contains('create-contract-meal');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ContractMeal $contractMeal): bool
    {
         return $user->getPermissionsViaRoles()->pluck('name')->contains('update-contract-meal');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContractMeal $contractMeal): bool
    {
         return $user->getPermissionsViaRoles()->pluck('name')->contains('delete-contract-meal');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ContractMeal $contractMeal): bool
    {
         return $user->getPermissionsViaRoles()->pluck('name')->contains('restore-contract-meal');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ContractMeal $contractMeal): bool
    {
         return $user->getPermissionsViaRoles()->pluck('name')->contains('force-delete-contract-meal');
    }
}
