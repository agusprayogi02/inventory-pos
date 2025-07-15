<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\Satuan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SatuanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can(PermissionsEnum::SATUAN_VIEW_ALL->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Satuan $satuan): bool
    {
        if ($user->can(PermissionsEnum::SATUAN_VIEW->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->can(PermissionsEnum::SATUAN_CREATE->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Satuan $satuan): bool
    {
        if ($user->can(PermissionsEnum::SATUAN_UPDATE->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Satuan $satuan): bool
    {
        if ($user->can(PermissionsEnum::SATUAN_DELETE->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Satuan $satuan): bool
    {
        if ($user->can(PermissionsEnum::SATUAN_RESTORE->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Satuan $satuan): bool
    {
        if ($user->can(PermissionsEnum::SATUAN_FORCE_DELETE->value)) {
            return true;
        }

        return false;
    }
}
