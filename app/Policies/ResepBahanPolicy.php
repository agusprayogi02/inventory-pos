<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\ResepBahan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ResepBahanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can(PermissionsEnum::RESEP_BAHAN_VIEW_ALL->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ResepBahan $resepBahan): bool
    {
        if ($user->can(PermissionsEnum::RESEP_BAHAN_VIEW->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->can(PermissionsEnum::RESEP_BAHAN_CREATE->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ResepBahan $resepBahan): bool
    {
        if ($user->can(PermissionsEnum::RESEP_BAHAN_UPDATE->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ResepBahan $resepBahan): bool
    {
        if ($user->can(PermissionsEnum::RESEP_BAHAN_DELETE->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ResepBahan $resepBahan): bool
    {
        if ($user->can(PermissionsEnum::RESEP_BAHAN_RESTORE->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ResepBahan $resepBahan): bool
    {
        if ($user->can(PermissionsEnum::RESEP_BAHAN_FORCE_DELETE->value)) {
            return true;
        }

        return false;
    }
}
