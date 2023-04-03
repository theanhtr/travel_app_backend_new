<?php

namespace App\Policies;

use App\Helper\CheckRoleAdmin;
use App\Models\Amenity;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AmenityPolicy
{
    public function before($user, $ability)
    {
        if (CheckRoleAdmin::checkRoleAdmin($user)) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Amenity $amenity): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Amenity $amenity): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Amenity $amenity): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Amenity $amenity): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Amenity $amenity): bool
    {
        return false;
    }
}
