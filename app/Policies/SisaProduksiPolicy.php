<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\SisaProduksi;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SisaProduksiPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can(PermissionsEnum::SISA_PRODUKSI_VIEW_ALL->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SisaProduksi $sisaProduksi): bool
    {
        if ($user->can(PermissionsEnum::SISA_PRODUKSI_VIEW->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->can(PermissionsEnum::SISA_PRODUKSI_CREATE->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SisaProduksi $sisaProduksi): bool
    {
        if ($user->can(PermissionsEnum::SISA_PRODUKSI_UPDATE->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SisaProduksi $sisaProduksi): bool
    {
        if ($user->can(PermissionsEnum::SISA_PRODUKSI_DELETE->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SisaProduksi $sisaProduksi): bool
    {
        if ($user->can(PermissionsEnum::SISA_PRODUKSI_RESTORE->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SisaProduksi $sisaProduksi): bool
    {
        if ($user->can(PermissionsEnum::SISA_PRODUKSI_FORCE_DELETE->value)) {
            return true;
        }

        return false;
    }
}
