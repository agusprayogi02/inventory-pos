<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\Bahan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BahanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can(PermissionsEnum::BAHAN_VIEW_ALL->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Bahan $bahan): bool
    {
        if ($user->can(PermissionsEnum::BAHAN_VIEW->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->can(PermissionsEnum::BAHAN_CREATE->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Bahan $bahan): bool
    {
        if ($user->can(PermissionsEnum::BAHAN_UPDATE->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Bahan $bahan): bool
    {
        if ($user->can(PermissionsEnum::BAHAN_DELETE->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Bahan $bahan): bool
    {
        if ($user->can(PermissionsEnum::BAHAN_RESTORE->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Bahan $bahan): bool
    {
        if ($user->can(PermissionsEnum::BAHAN_FORCE_DELETE->value)) {
            return true;
        }

        return false;
    }
}
