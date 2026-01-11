<?php

namespace App\Policies;

use App\Models\Brand;
use App\Models\User;

class BrandPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return in_array($user->role_id, [
            User::ROLE_ADMIN,
            User::ROLE_MANAGER,
            User::ROLE_STAFF,
        ]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Brand $brand): bool
    {
        //
        return in_array($user->role_id, [
            User::ROLE_ADMIN,
            User::ROLE_MANAGER,
            User::ROLE_STAFF,
        ]);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return in_array($user->role_id, [
            User::ROLE_ADMIN,
            User::ROLE_MANAGER,
        ]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Brand $brand): bool
    {
        //
        return in_array($user->role_id, [
            User::ROLE_ADMIN,
            User::ROLE_MANAGER,
        ]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Brand $brand): bool
    {
        //
        return $user->role_id === User::ROLE_ADMIN;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Brand $brand): bool
    {
        //
        return $user->role_id === User::ROLE_ADMIN;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Brand $brand): bool
    {
        //
        return $user->role_id === User::ROLE_ADMIN;
    }
}
