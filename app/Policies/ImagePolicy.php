<?php

namespace App\Policies;

use App\Helper\CheckRoleAdmin;
use App\Models\User;
use App\Models\Image;
use Illuminate\Auth\Access\Response;

class ImagePolicy
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
    public function view(User $user, Image $image): bool
    {
        return $user->id === $image->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Image $image): bool
    {
        return $user->id === $image->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Image $image): bool
    {
        return $user->id === $image->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Image $image): bool
    {
        return $user->id === $image->user_id;
    }
}