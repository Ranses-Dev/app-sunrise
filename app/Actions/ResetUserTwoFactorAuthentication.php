<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;

class ResetUserTwoFactorAuthentication
{
    protected UserRepositoryInterface $repository;
    /**
     * Create a new class instance.
     */
    public function __construct(UserRepositoryInterface $userRepositoryInterface, int|null $userId = null)
    {
        $this->repository = $userRepositoryInterface;
        if ($userId) {
            $user = $this->repository->findById($userId);
            if ($user) {
                $this->reset($user);
            }
        }
    }

    /**
     * Reset the user's two-factor authentication.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function reset(User $user): void
    {
        // Ensure the user has two-factor authentication enabled
        if ($user->two_factor_secret_app || $user->two_factor_secret) {

            $user->forceFill([
                'two_factor_secret_app' => null,
                'two_factor_recovery_codes_app' => null,
                'two_factor_confirmed_at_app' => null,
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
            ])->save();
        }
    }
}
