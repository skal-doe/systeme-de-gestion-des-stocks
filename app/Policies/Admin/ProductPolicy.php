<?php

namespace App\Policies\Admin;

use App\Models\User;
use App\Models\Product;
use App\Enums\UserRoleEnum;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [
            UserRoleEnum::ADMIN,
            UserRoleEnum::MANAGER,
            UserRoleEnum::COMMERCIAL,
        ]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Product $product): bool
    {
        return in_array($user->role, [
            UserRoleEnum::ADMIN,
            UserRoleEnum::MANAGER,
            UserRoleEnum::COMMERCIAL,
        ]);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, [
            UserRoleEnum::ADMIN,
            UserRoleEnum::MANAGER,
        ]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): bool
    {
        return in_array($user->role, [
            UserRoleEnum::ADMIN,
            UserRoleEnum::MANAGER,
        ]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): bool
    {
        return in_array($user->role, [
            UserRoleEnum::ADMIN,
            UserRoleEnum::MANAGER,
        ]);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Product $product): bool
    {
        return in_array($user->role, [
            UserRoleEnum::ADMIN,
            UserRoleEnum::MANAGER,
        ]);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Product $product): bool
    {
        return in_array($user->role, [
            UserRoleEnum::ADMIN,
            UserRoleEnum::MANAGER,
        ]);
    }
}
