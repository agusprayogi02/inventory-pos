<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProdukPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can(PermissionsEnum::PRODUK_VIEW_ALL->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Produk $produk): bool
    {
        if ($user->can(PermissionsEnum::PRODUK_VIEW->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->can(PermissionsEnum::PRODUK_CREATE->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Produk $produk): bool
    {
        if ($user->can(PermissionsEnum::PRODUK_UPDATE->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Produk $produk): bool
    {
        if ($user->can(PermissionsEnum::PRODUK_DELETE->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Produk $produk): bool
    {
        if ($user->can(PermissionsEnum::PRODUK_RESTORE->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Produk $produk): bool
    {
        if ($user->can(PermissionsEnum::PRODUK_FORCE_DELETE->value)) {
            return true;
        }

        return false;
    }
}
