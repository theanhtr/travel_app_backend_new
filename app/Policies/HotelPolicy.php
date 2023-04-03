<?php

namespace App\Policies;

use App\Helper\CheckRoleAdmin;
use App\Helper\GetRoleIdHelper;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HotelPolicy
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
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Hotel $Hotel): bool
    {
        return $user->id === $Hotel->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role_id === GetRoleIdHelper::getHotelManagerRoleId();
    }

    public function createAmenities(User $user, Hotel $Hotel): bool
    {
        return $user->id === $Hotel->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Hotel $Hotel): bool
    {
        return $user->id === $Hotel->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Hotel $Hotel): bool
    {
        return $user->id === $Hotel->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Hotel $Hotel): bool
    {
        return $user->id === $Hotel->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Hotel $Hotel): bool
    {
        return $user->id === $Hotel->user_id;
    }
}
